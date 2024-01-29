<?php
/*
** الاصدار 3
** دالة جلب الاصناف 
*/
function getAllFrom($filed, $table, $condition = null, $conValue = null, $Join = null, $Gorp = null, $ordering = null, $limit = 100000)
{
  $cond = ($condition == null) ? '1' : $condition;
  $arr = ($conValue == null) ? null :  explode(',', $conValue);
  global $con;
  $stmt2 = $con->prepare("SELECT $filed FROM $table $Join WHERE   $cond    $Gorp  $ordering LIMIT  $limit");
  $stmt2->execute($arr);
  return $stmt2->fetchAll();
}
/*
**v2.0
** هذه الدالة تجلب عدد الاسطر 
**دمج الدالتين checkItem + countItems
*/
function checkCount($select, $table, $condition, $conValue = null,$Gorp = null)
{
  global $con;
  $cond = ($condition == null) ? 1 : $condition;
  $arr = ($conValue == null) ? null :  explode(',', $conValue);

  $stmt = $con->prepare("SELECT $select FROM $table WHERE    $cond  $Gorp");

  $stmt->execute($arr);

  $count = $stmt->rowCount();

  return $count;
}

function checkItem($select, $from, $value)
{
  global $con;

  $statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");

  $statement->execute(array($value));

  $count = $statement->rowCount();

  return $count;
}
/*
الاصدار1.0
دالة تغيير عنوان صحفات تلقائيا
*/
function getTitle()
{
  global $PageTitle;

  if (isset($PageTitle)) {

    return $PageTitle;
  } else {

    //في لا يوجد عنوان للمتغير عنوان حطو
    return 'Default';
  }
}
/*
الاصدار1.0
دالة تغيير عنوان صحفات تلقائيا
*/
function activeLinkSide($linkName)
{
  global $PageTitle;

  if ($PageTitle == $linkName) {

    echo "active";
  } else {

    //في لا يوجد عنوان للمتغير عنوان حطو
    echo '';
  }
}



function redirectHome($theMsg, $url = null, $seconds = 3)
{
  //اذاكان مخليها فارغة رجعو لصفحة الرئسية
  if ($url === null) {

    $url = 'index.php';

    $link = 'Homepage';
  } else {    //اذا كانت معمرة لكن قالط في الكتيبة ترجعني لصفحة لي قبلها
    // اذاكان كاين الصفحة لي ترجعلهارجعو
    if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {

      //متغيرات الصفحة لي قبلها
      $url = $_SERVER['HTTP_REFERER'];

      $link = 'Previous Page';
    } else {

      //اذا كان  مكانش الصفحة
      $url = 'index.php';

      $link = 'Homepage';
    }
  }
  //هذا متغيير الرسالة
  echo  $theMsg;

  echo  "<div class='alert alert-info'>You Be Redirected to $link After $seconds Seconds</div>";

  header(("refresh:$seconds;url=$url"));

  exit();
}

//delete

function delete($filed, $table, $cond,$id)
{
  global $con;

  $count = checkCount($filed, $table, $cond . '=?' , $id);

  if ($count > 0) {

    $stmt = $con->prepare("DELETE FROM $table WHERE $filed = :id");
    $stmt->bindParam(':id',  $id);
    $stmt->execute();
  }
}


//insert
function Insert($table, $name = null, $cond = null, $fields, $values)
{
  global $con;
  if ($name !== null) {
    $count = checkCount("*", $table, $cond . '=?', $name);
  } else {
    $count = 0;
  }

  if ($count == 0) {
    $fieldsStr = implode(', ', $fields);
    $valuesStr = implode(', ', array_map(function ($field) {
      return ':' . $field;
    }, $fields));

    $stmt = $con->prepare("INSERT INTO $table ($fieldsStr) VALUES ($valuesStr)");

    // ربط القيم بالمتغيرات المعينة
    foreach ($fields as $i => $field) {
      $stmt->bindParam(':' . $field, $values[$i]);
    }
    // يجب على الأقل تنفيذ الاستعلام بعد الربط
    $stmt->execute();
  }
}


//update

function update($table, $id, $cond, $fields, $values)
{
  global $con;
  
  $stmt = $con->prepare("SELECT * FROM $table WHERE $cond = :id");
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->execute();

  $count = $stmt->rowCount();
  if ($count > 0) {
    $placeholders = implode(', ', array_map(function ($field) {
      return $field . ' = :' . $field;
    }, $fields));

    $stmt = $con->prepare("UPDATE $table SET $placeholders WHERE $cond = :id");

    // ربط القيم بالمتغيرات المعينة
    foreach ($fields as $i => $field) {
      $stmt->bindParam(':' . $field, $values[$i]);
    }
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    $stmt->execute();
  }
}
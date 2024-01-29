<?php
ob_start();

session_start();


//اذا راه داخل لصفحة باسم المستخد والرقم السري  خليه داخل
if (isset($_SESSION['admin'])) {
  $PageTitle = 'Manage';
  include "init.php";
  $do = isset($_GET['do']) ? $_GET['do'] : "";
  $table = isset($_GET['table']) ? $_GET['table'] : "";
  //Delete
  if ($do == "Delete") :
    $id = (isset($_GET['id']) && is_numeric($_GET['id'])) ?  intval($_GET['id']) : 0;
    if ($_GET["table"] == "prod") :
      delete('id', 'products', "id", $id);

    elseif ($_GET["table"] == "cat") :
      $_GET["id"] =
        delete('cat_id', 'categories', "cat_id", $id);
    endif;
  endif;

  //insert && Update

  if ($do == "Insert") :
    if ($_SERVER['REQUEST_METHOD'] == 'POST') :
      if ($table == "cat") :
        $nameCat = $_POST['name_c'];
        if (isset($_POST['not_sale'])) {
          $notSale = $_POST['not_sale'];
        } else {
          $notSale = 0;
        }
        Insert("categories", $nameCat, "cat_name", ["cat_name", "not_sale"], [$nameCat, $notSale]);
      elseif ($table == "prod") :
        $name = $_POST['name_p'];
        $price =  $_POST['price_p'];
        $sellingPrice =  $_POST['selling_price'];
        $idCat =  $_POST['cat_id'];

        Insert("products", $name, "name", ["name", "price", "price_selling", "category_id"], [$name, $price, $sellingPrice, $idCat]);

      endif;
      header("location:manage.php");

    endif;

  elseif ($do == "Update") :
    if ($_SERVER['REQUEST_METHOD'] == 'POST') :

      if ($table == "cat") :

        $id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? intval($_GET['id']) : 0;
        $nameCat = $_POST['name_c'];
        if (isset($_POST['not_sale'])) {
          $notSale = $_POST['not_sale'];
        } else {
          $notSale = 0;
        }

        update("categories", $id, "cat_id", ["cat_name", "not_sale"], [$nameCat,  $notSale]);

      elseif ($table == "prod") :
        $id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? intval($_GET['id']) : 0;
        $name = $_POST['name_p'];
        $price =  $_POST['price_p'];
        $sellingPrice =  $_POST['selling_price'];
        $idCat =  $_POST['cat_id'];
        update("products", $id, "id", ["category_id", "name", "price", "price_selling"], [$idCat, $name, $price, $sellingPrice]);

      endif;

    endif;
    header("location:manage.php");

  endif;


?>

  <?php


  if ($do == "Edit") :
    if ($_GET["table"] == "prod") {

      $productId = (isset($_GET['id']) && is_numeric($_GET['id'])) ?  intval($_GET['id']) : 0;
      $product =  getAllFrom(
        '*', 
        'products', 
        "id=?", $productId);
      $count =    checkCount('*', 'products', 'id=?', $productId);
      if ($count > 0) {
        $name = $product[0]['name'];
        $price = $product[0]['price'];
        $sellingPrice = $product[0]['price_selling'];
      }
    } elseif ($_GET["table"] == "cat") {
      $cat_id = (isset($_GET['id']) && is_numeric($_GET['id'])) ?  intval($_GET['id']) : 0;

      $category =  getAllFrom(
        '*', 
        'categories',
         "cat_id=?",
          $cat_id);

      $count = checkCount(
        '*', 
        'categories', 
        'cat_id=?', 
        $cat_id);

      if ($count > 0) {
        $nameCat = $category[0]['cat_name'];
      }
    }


  endif;


  ?>
  <?
  ?>


  <div class="page-body">
    <form action="<?php if ($do == "Edit") {
                    echo "?table=cat&do=Update&id=" . $_GET["id"];
                  } elseif ($do == "") {
                    echo "?table=cat&do=Insert";
                  }  ?>" method="POST">

      <div class="input-con">
        <label class="title" for=""> <?php echo lang('category') ?></label>

        <input placeholder="<?php echo lang("p-hold")["category"] ?>" name="name_c" type="text" value="<?php echo (isset($nameCat)) ? $nameCat : '' ?>" />

      </div>
      <input name="not_sale" class="check" value="0" type="checkbox" />

      <div class="input-con">
        <button class="add" type="submit"><?php echo ($do == "Edit") ? '<i class="fa-solid fa-square-pen"></i>' . lang('update') : '<i class="fa-solid fa-plus"></i>' . lang('add') ?></button>
      </div>
    </form>
    <form action=" <?php if ($do == "Edit") {
                      echo "?table=prod&do=Update&id=" . $_GET["id"];
                    } elseif ($do == "") {
                      echo "?table=prod&do=Insert";
                    }  ?>" method="POST">
      <div class="input-con">
        <label class="title" for=""><?php echo lang('product') ?></label>

        <input placeholder="<?php echo lang("p-hold")["product"] ?>" name="name_p" type="text" value="<?php echo (isset($name)) ? $name : '' ?>" />

      </div>
      <div class="input-con">
        <label class="title" for=""><?php echo lang('chose category') ?></label>
        <select name="cat_id">
          <option value="0">...</option>
          <?php
          $categories = getAllFrom(
            '*', 
            'categories');

          foreach ($categories as  $category) :
          ?>
            <option value="<?php echo $category["cat_id"]   ?>" <?php echo (isset($_GET['cat_id']) && $_GET['cat_id'] == $category["cat_id"]) ? 'selected' : '' ?>><?php echo $category["cat_name"] ?></option>
          <?php
          endforeach;

          ?>
        </select>
      </div>
      <div class="input-con">
        <label class="title" for=""> <?php echo lang('price_of_product') ?></label>
        <input placeholder="<?php echo lang("p-hold")["price"] ?>" name="price_p" min=1 type="text" title="يرجى إدخال قيمة رقمية صحيحة" pattern="\d+(\.\d+)?" value="<?php echo (isset($price)) ?  $price : '' ?>" />
      </div>
      <div class="input-con">
        <label class="title" for=""> <?php echo lang('selling_price') ?></label>
        <input placeholder="<?php echo lang("p-hold")["price"] ?>" name="selling_price" pattern="\d+(\.\d+)?" title="يرجى إدخال قيمة رقمية صحيحة" min=1 type="text" value="<?php echo (isset($sellingPrice)) ?  $sellingPrice : '' ?>" />
      </div>
      <div class="input-con">
        <button class="add" type="submit"><?php echo ($do == "Edit") ? '<i class="fa-solid fa-square-pen"></i>' . lang('update') : '<i class="fa-solid fa-plus"></i>' . lang('add') ?></button>
      </div>
    </form>
    <?php


    if (!empty($categories)) :
      $id = 0;
    ?>
      <div class="table-container">
        <table class="info-table">
          <thead>
            <tr>
              <td><?php echo lang('id') ?></td>
              <td><?php echo lang('category') ?></td>
              <td><?php echo lang('status') ?></td>
              <td><?php echo lang('edit/delete') ?></td>
            </tr>
          </thead>
          <tbody>

            <?php foreach ($categories as $category) :
              $id++;
            ?>
              <tr>
                <td> <?php echo  $id ?> </td>
                <td><?php echo $category['cat_name'] ?> </td>
                <td><?php echo ($category['not_sale'] == 0) ? lang('for sale') : lang('not sale') ?> </td>
                <td>
                  <span>
                    <a href='manage.php?do=Edit&id=<?php echo $category['cat_id'] . "&table=cat" ?>'> <i class="fa-solid fa-pen-to-square edit"></i></a>
                  </span><span><a href='manage.php?do=Delete&id=<?php echo $category['cat_id'] . "&table=cat" ?>'><i class=" fa-solid fa-trash delete"></i></a></span>

                </td>
              </tr>
            <?php
            endforeach;
            ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
    <?php

    $id_category = getAllFrom(
      'category_id', 
      "products", 
      "", "", "",
       " GROUP BY(`category_id`)");
    if (!empty($id_category)) :
      $id = 0;
    ?>
      <div class="table-container">
        <table class="info-table">
          <thead>
            <tr>
              <td><?php echo lang('category') ?></td>
              <td><?php echo lang('product') ?></td>
              <td><?php echo lang('price') ?></td>
              <td><?php echo lang('selling_price') ?></td>
              <td><?php echo lang('edit/delete') ?></td>
            </tr>
          </thead>
          <tbody>


            <?php
            foreach ($id_category as $id_category1) :
              $products =  getAllFrom(
                "*", 
                "products",  
                 "category_id=" . $id_category1["category_id"], 
                  '',
                   "JOIN categories ON categories.cat_id=products.category_id ");


              foreach ($products as $product) :
                $id++;
            ?>
                <tr>
                  <td> <?php echo  $product['cat_name']  ?> </td>
                  <td><?php echo $product['name'] ?> </td>
                  <td class="price_p"> <?php echo $product['price'] ?> </td>
                  <td class="price_p"> <?php echo $product['price_selling'] ?> </td>
                  <td>
                    <span>
                      <a href='manage.php?do=Edit&id=<?php echo $product['id'] . "&table=prod" . "&cat_id=" . $id_category1['category_id'] ?>'> <i class="fa-solid fa-pen-to-square edit"></i></a>
                    </span><span><a href='manage.php?do=Delete&id=<?php echo $product['id'] . "&table=prod" ?>'><i class=" fa-solid fa-trash delete"></i></a></span>

                  </td>
                </tr>
            <?php
              endforeach;
            endforeach;
            ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
  </div>
  </div>
  </div>
  </div>


  <?php include  $tpl . 'footer.php';
  ?>
  </body>
<?php } ?>
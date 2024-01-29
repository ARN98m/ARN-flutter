<?php
ob_start();

session_start();


//اذا راه داخل لصفحة باسم المستخد والرقم السري  خليه داخل
if (isset($_SESSION['admin'])) {



  $PageTitle = 'Manage';


  include "init.php";

  $do = isset($_GET['do']) ? $_GET['do'] : "f";
  $table = isset($_GET['table']) ? $_GET['table'] : "";

  //Delete
  if ($do == "Delete") :
    if ($_GET["table"] == "prod") :
      delete('id', 'products', "id");

    elseif ($_GET["table"] == "cat") :
      delete('cat_id', 'categories', "cat_id");
    endif;
  endif;


  //insert && Update

  if ($do == "Insert") :
    echo "Insert";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') :
      if ($table == "cat") :
echo "Insert categories";


        // $nameCat = $_POST['name_c'];
        //   $stmt = $con->prepare("SELECT * FROM categories WHERE cat_name = :name");
        //   $stmt->bindParam(':name', $nameCat, PDO::PARAM_STR);
        //   $stmt->execute();
    

        // $count = $stmt->rowCount();

        // $formErrors = array();
        // if (strlen($nameCat) < 2) {
        //   $formErrors[] = 'name Cant Be Less Than <strong>2 Characters</strong>';
        // }


        // foreach ($formErrors as $error) {
        //   $errorMsg = '<div class="alert alert-danger">' . $error . '</div>';
        // }


        // if (empty($formErrors)) :
        //   if ($count == 0) :
        //     $stmt = $con->prepare("INSERT INTO 
        //     categories(cat_name)
        //   VALUES(:cat_name) ");
        //     $stmt->execute(array(
        //       'cat_name'     => $nameCat,

        //     ));
        //   endif;
        // endif;


      elseif ($table == "prod") :
        echo "Insert prod";


      endif;
    endif;

  elseif ($do = "Update") :
    if ($_SERVER['REQUEST_METHOD'] == 'POST') :

      if ($table == "cat") :







      elseif ($table == "prod") :

      endif;

    endif;
  endif;







  // if ($_SERVER['REQUEST_METHOD'] == 'POST') :
  //   if ($_GET["table"] == "cat") :
  //     $nameCat = $_POST['name_c'];

  //     if (isset($_GET['id'])) {
  //       $cat_id = (isset($_GET['id']) && is_numeric($_GET['id'])) ?  intval($_GET['id']) : 0;

  //       $stmt = $con->prepare("SELECT * FROM categories WHERE cat_id = :category_id");
  //       $stmt->bindParam(':category_id', $cat_id, PDO::PARAM_STR);
  //       $stmt->execute();
  //     } else {
  //       $stmt = $con->prepare("SELECT * FROM categories WHERE cat_name = :name");
  //       $stmt->bindParam(':name', $nameCat, PDO::PARAM_STR);
  //       $stmt->execute();
  //     }

  //     $count = $stmt->rowCount();

  //     $formErrors = array();
  //     if (strlen($nameCat) < 2) {
  //       $formErrors[] = 'name Cant Be Less Than <strong>2 Characters</strong>';
  //     }


  //     foreach ($formErrors as $error) {
  //       $errorMsg = '<div class="alert alert-danger">' . $error . '</div>';
  //     }


  //     if (empty($formErrors)) :
  //       if ($do == "Insert") :
  //         if ($count == 0) :
  //           $stmt = $con->prepare("INSERT INTO 
  //     categories(cat_name)
  //   VALUES(:cat_name) ");
  //           $stmt->execute(array(
  //             'cat_name'     => $nameCat,

  //           ));
  //         endif;
  //       elseif ($do == "Update") :

  //         if ($count > 0) :
  //           $stmt = $con->prepare(
  //             "UPDATE `categories` SET `cat_name`=?  WHERE `cat_id`=?"
  //           );
  //           $stmt->execute(array($nameCat, $cat_id));

  //         endif;

  //       endif;


  //     endif;

  //   elseif ($_GET["table"] == "prod") :

  //     $name = $_POST['name_p'];
  //     $price =  $_POST['price_p'];
  //     $sellingPrice =  $_POST['selling_price'];
  //     $idCat =  $_POST['cat_id'];



  //     if (isset($_GET['id'])) {
  //       $prod_id = (isset($_GET['id']) && is_numeric($_GET['id'])) ?  intval($_GET['id']) : 0;

  //       $stmt = $con->prepare("SELECT * FROM products WHERE id = :id");
  //       $stmt->bindParam(':id', $prod_id, PDO::PARAM_STR);
  //       $stmt->execute();
  //     } else {
  //       $stmt = $con->prepare("SELECT * FROM products WHERE name = :name");
  //       $stmt->bindParam(':name', $name, PDO::PARAM_STR);
  //       $stmt->execute();
  //     }


  //     $count = $stmt->rowCount();


  //     $formErrors = array();
  //     if (strlen($name) < 2) {
  //       $formErrors[] = 'name Cant Be Less Than <strong>2 Characters</strong>';
  //     }
  //     if (!is_numeric($price)) {
  //       $formErrors[] = 'price must be a  <strong>number</strong>';
  //     }


  //     foreach ($formErrors as $error) {
  //       $errorMsg = '<div class="alert alert-danger">' . $error . '</div>';
  //     }

  //     if (empty($formErrors)) :
  //       if ($do == "Insert") :

  //         if ($count == 0) :
  //           $stmt = $con->prepare("INSERT INTO products (category_id, name, price, price_selling) VALUES (:category_id, :name, :price, :selling_price)");
  //           $stmt->execute(array(
  //             ':category_id'    => $idCat,
  //             ':name'           => $name,
  //             ':price'          => $price,
  //             ':selling_price'  => $sellingPrice
  //           ));



  //         endif;

  //       elseif ($do == "Update") :

  //         if ($count > 0) :
  //           $stmt = $con->prepare(
  //             "UPDATE `products` SET `category_id`=? ,`name`=?,`price`=?,`price_selling`=? WHERE `id`=?"
  //           );
  //           $stmt->execute(array($idCat,$name, $price,$sellingPrice,$prod_id));


  //         endif;


  //       endif;


  //     endif;


  //   endif;
  //   header("location:manage.php");

  // endif;



?>

  <?php


  if ($do == "Edit") :
    if ($_GET["table"] == "prod") {

      $productId = (isset($_GET['id']) && is_numeric($_GET['id'])) ?  intval($_GET['id']) : 0;
      $product = getAllFrom('*', 'products', 'id=' . $productId, 'id');
      $count =  checkCount('*', 'products', 'id=' . $productId);

      if ($count > 0) {
        $name = $product[0]['name'];
        $price = $product[0]['price'];
        $sellingPrice = $product[0]['price_selling'];
      }
    } elseif ($_GET["table"] == "cat") {
      $cat_id = (isset($_GET['id']) && is_numeric($_GET['id'])) ?  intval($_GET['id']) : 0;
      $category = getAllFrom('*', 'categories', 'cat_id=' . $cat_id, 'cat_id');
      $count =  checkCount('*', 'categories', 'cat_id=' . $cat_id);

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
                  } elseif ($do == "f") {
                    echo "?table=cat&do=Insert";
                  }  ?>" method="POST">

      <div class="input-con">
        <label class="title" for=""> <?php echo lang('category') ?></label>

        <input placeholder="<?php echo lang("p-hold")["category"] ?>" name="name_c" type="text" value="<?php echo (isset($nameCat)) ? $nameCat : '' ?>" />


      </div>
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
          $categories = getAllFrom1('*', 'categories');
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
        <input placeholder="<?php echo lang("p-hold")["price"] ?>" name="price_p" min=1 type="number" value="<?php echo (isset($price)) ?  $price : '' ?>" />
      </div>
      <div class="input-con">
        <label class="title" for=""> <?php echo lang('selling_price') ?></label>
        <input placeholder="<?php echo lang("p-hold")["price"] ?>" name="selling_price" min=1 type="number" value="<?php echo (isset($sellingPrice)) ?  $sellingPrice : '' ?>" />
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
              <td><?php echo lang('product') ?></td>
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

    $id_category = getAllFrom1('category_id', "products", "", "", "", " GROUP BY(`category_id`)");
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
              $products =  getAllFrom1("*", "products",   "category_id=" . $id_category1["category_id"],  '', "JOIN categories ON categories.cat_id=products.category_id ");


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
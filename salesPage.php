<?php
ob_start();

session_start();


//اذا راه داخل لصفحة باسم المستخد والرقم السري  خليه داخل
if (isset($_SESSION['admin'])) {


  $PageTitle = 'SalesPage';
  include "init.php";






  if ($_SERVER['REQUEST_METHOD'] == 'POST') :



    $id_product = $_POST['id'];
    $id_product = explode(",", $id_product);

    $price =  $_POST['price_p'];
    $nbPieces = $_POST['nb_pieces'];



    Insert(
      "my_sales",
      $id_product[0],
      "id_product",
      ["id_product", "old_price", "quantity", "date"],
      [$id_product[0], $price, $nbPieces, date("y-m-d", strtotime("yesterday"))]
    );

    update(
      "my_sales",
      $id_product[0],
      "id_product",
      ["id_product", "old_price", "quantity", "date"],
      [$id_product[0], $price, $nbPieces, date("y-m-d", strtotime("yesterday"))]

    );



  endif;



?>
  <div class="page-body">
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
      <div class="input-con">
        <label class="title" for=""><?php echo lang('chose product') ?></label>
        <select name="id" class="productSelect productSales">
          <option value="0">...</option>
          <?php
          $products = getAllFrom(
            "products.name,products.id, my_purchases.id_purchases",
            "products",
            "categories.not_sale=? AND my_purchases.date=?",
            "0," . date("y-m-d", strtotime("yesterday")),
            "JOIN my_purchases ON my_purchases.id_product = products.id JOIN categories ON categories.cat_id = products.category_id"
          );
          foreach ($products as  $product) :
            # code...
          ?>
            <option value="<?php echo $product["id"] . ',' . $product["id_purchases"] ?>"><?php echo $product["name"] ?></option>
          <?php

          endforeach;

          ?>
        </select>
      </div>
      <div class="input-con">
        <label class="title" for=""><?php echo lang('price') ?> </label>
        <input name="price_p" class="price" pattern="\d+(\.\d+)?" title="يرجى إدخال قيمة رقمية صحيحة" min=1 type="text" value="0" min=1 />
      </div>
      <div class="input-con">
        <label class="title" for=""><?php echo lang('nb_pieces') ?></label>
        <input class="quant nb_pieces" pattern="\d+(\.\d+)?" title="يرجى إدخال قيمة رقمية صحيحة" min=1 type="text" name="nb_pieces" type="text" min=1 placeholder="<?php echo lang("p-hold")["nb_pieces"] ?>" />
      </div>
      <div class="input-con"><span class="title"><?php echo lang('price Total') ?></span><span class="price-t">DZD 0.00
        </span></div>
      <div class="input-con">
        <button type="submit" class="add"> <i class="fa-solid fa-shop"></i><?php echo lang('shop') ?>
        </button>

      </div>
    </form>
  </div>
  </div>
  </div>
  </div>
  </div>
  <?php include  $tpl . 'footer.php';
  ?>

  </body>
<?php } ?>
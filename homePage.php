<?php
ob_start();

session_start();


//اذا راه داخل لصفحة باسم المستخد والرقم السري  خليه داخل
if (isset($_SESSION['admin'])) {

  $PageTitle = 'HomePage';
  include "init.php";





  if ($_SERVER['REQUEST_METHOD'] == 'POST') :
    $id_product = $_POST['id'];


    $numberPiecesPaying =  getAllFrom(
      "SUM(`nb_pieces`) AS total_pieces",
      "my_purchases",
      "date=? AND id_product=?",
      date("y-m-d", strtotime("-2days")) . "," . $id_product
    );


    $numberPiecesSale =  getAllFrom(
      " SUM(`quantity`) AS total_quantity",
      "my_sales",
      "date=? AND id_product=?",
      date("y-m-d", strtotime("-2days")) . "," . $id_product,
    );



    // تحقق من وجود بيانات في المصفوفات
    if (!empty($numberPiecesPaying) && !empty($numberPiecesSale)) {
      $restPieces = $numberPiecesPaying[0]["total_pieces"] - $numberPiecesSale[0]["total_quantity"];
    } else {
      $restPieces = 0;
    }

    $price =  $_POST['price_p'];
    $quant = $_POST['quant'];
    if ($_POST['nb_pieces'] !== "") {
      $nbPieces = $_POST['nb_pieces'] + $restPieces;
    } else {
      $nbPieces = 0;
    }

    if (checkCount('*', 'products', 'id=?', $id_product) > 0) :


      $count = checkCount('*', 'my_purchases', 'id_product=? AND date=?', $id_product . "," .  date("y-m-d", strtotime("-1days")));


      if ($count == 0) {
        Insert(
          "my_purchases",
          null,
          null,
          ["id_product", "quantity", "old_price", "nb_pieces", "date"],
          [$id_product, $quant, $price, $nbPieces, date("y-m-d", strtotime("-1days"))]
        );
      } else {

        $stmt = $con->prepare('UPDATE `my_purchases` 
                                  SET `quantity` = ?, `old_price` = ?, `nb_pieces` = ?  
                                  WHERE `id_product` = ? AND DATE(`date`) = CURDATE() - INTERVAL 1 DAY');
        $stmt->execute(array($quant, $price, $nbPieces, $id_product));
      }

      header("refresh:0;url=reloaded.php");
      exit();
    endif;
  endif;



?>
  <div class="page-body">
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
      <div class="input-con">
        <label class="title" for=""><?php echo lang('chose product') ?></label>
        <select name="id" class="productSelect productPurchases">
          <option value="0">...</option>
          <?php
          $products = getAllFrom(
            '*',
            'products'
          );
          foreach ($products as  $product) :
          ?>
            <option value="<?php echo $product["id"]   ?>"><?php echo $product["name"] ?></option>
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
        <label class="title" for=""><?php echo lang('quantity') ?></label>
        <input class="quant" pattern="\d+(\.\d+)?" title="يرجى إدخال قيمة رقمية صحيحة" min=1 type="text" name="quant" type="text" min=1 placeholder="<?php echo lang("p-hold")["quant"] ?>" />
      </div>
      <div class="input-con">
        <label class="title" for=""><?php echo lang('nb_pieces') ?></label>
        <input class="quant" pattern="\d+(\.\d+)?" title="يرجى إدخال قيمة رقمية صحيحة" min=1 type="text" name="nb_pieces" type="text" min=1 placeholder="<?php echo lang("p-hold")["nb_pieces"] ?>" />
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
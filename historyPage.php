<?php
ob_start();

session_start();


//اذا راه داخل لصفحة باسم المستخد والرقم السري  خليه داخل
if (isset($_SESSION['admin'])) {



  $PageTitle = 'My history';
  include "init.php";

  $do = isset($_GET['do']) ? $_GET['do'] : "";


  if ($do == "Delete") {

    $cat = $_GET["cat"];
    if ($cat == "purchases") {
      $id_purchases = (isset($_GET['id_purchases']) && is_numeric($_GET['id_purchases'])) ?  intval($_GET['id_purchases']) : 0;

      delete(
        'id_purchases',
        'my_purchases',
        "id_purchases",
        $id_purchases
      );
    } else {
      $id_sales = (isset($_GET['id_sales']) && is_numeric($_GET['id_sales'])) ?  intval($_GET['id_sales']) : 0;

      delete(
        'id_sales',
        'my_sales',
        "id_sales",
        $id_sales
      );
    }
  }





?>

  <div class="page-body">
    <ul class="info">
      <li class="active" data-type="purchases">مشرياتي</li>
      <li data-type="sales">مبيعاتي</li>
      <li data-type="profits">ارباحي</li>
      <li data-type="chart"><?php echo lang('My stats') ?> </li>
    </ul>

    <?php
    $id = 0;
    $totalPurchases = [];

    $Days1 = getAllFrom(
      'date',
      'my_purchases',
      '',
      '',
      '',
      'GROUP BY date',
      'ORDER BY `date` DESC '
    );
    if (!empty($Days1)) :
    ?>

      <div class="table-container table-type active purchases">
        <table class="info-table">
          <thead>
            <tr>
              <td> <?php echo lang('id') ?> </td>
              <td><?php echo lang('date') ?> </td>
              <td><?php echo lang('Nb Of Products') ?> </td>
              <td><?php echo lang('price Total') ?></td>
              <td><?php echo lang('view') ?></td>
            </tr>
          </thead>
          <tbody>


            <?php
            foreach ($Days1 as $Day) :
              $id++;
              $total = 0;


              $my_purchases = getAllFrom(
                "old_price, SUM(quantity) as total_quantity",
                "my_purchases",
                "date=?",
                $Day['date'],
                "",
                " GROUP BY id_product"
              );

              $totalProduct =  checkCount(
                "old_price,
               SUM(quantity) as total_quantity ",
                "my_purchases",
                "date=?",
                $Day['date'],
                " GROUP BY id_product"
              );

              foreach ($my_purchases as $product) {
                $total = $total + $product["old_price"] * $product["total_quantity"];
              }
              $totalPurchases[$Day["date"] . "_p"] = -$total;
            ?>
              <tr data-prod="p<?php echo $id ?>">
                <td><?php echo $id ?></td>
                <td><?php echo $Day['date'] ?></td>
                <td><?php echo     $totalProduct ?></td>
                <td class="price_p"><?php echo $total ?></td>
                <td><i class="fa-solid fa-eye-slash show-more"></i></td>
              </tr>
            <?php
            endforeach;
            ?>

          </tbody>
        </table>
      </div>


    <?php
    endif;
    ?>
    <?php
    $id = 0;
    $totalSales = [];

    $Days2 = getAllFrom(
      'date',
      'my_sales',
      '',
      '',
      '',
      'GROUP BY date',
      'ORDER BY `date` DESC '
    );

    if (!empty($Days2)) :
    ?>

      <div class="table-container table-type  sales">
        <table class="info-table">
          <thead>
            <tr>
              <td> <?php echo lang('id') ?> </td>
              <td><?php echo lang('date') ?> </td>
              <td><?php echo lang('Nb Of Products') ?> </td>
              <td><?php echo lang('price Total') ?></td>
              <td><?php echo lang('view') ?></td>
            </tr>
          </thead>
          <tbody>


            <?php
            foreach ($Days2 as $Day) :
              $id++;
              $total = 0;


              $my_sales = getAllFrom(
                "old_price, SUM(quantity) as total_quantity",
                "my_sales",
                "date=?",
                $Day['date'],
                "",
                " GROUP BY id_product"
              );


              $totalProduct =  checkCount(
                "old_price,
               SUM(quantity) as total_quantity ",
                "my_sales",
                "date=?",
                $Day['date'],
                " GROUP BY id_product"
              );


              foreach ($my_sales as $product) {
                $total = $total + $product["old_price"] * $product["total_quantity"];
              }
              $totalSales[$Day["date"] . "_s"] = $total;
            ?>
              <tr data-prod="s<?php echo $id ?>">
                <td><?php echo $id ?></td>
                <td><?php echo $Day['date'] ?></td>
                <td><?php echo     $totalProduct ?></td>
                <td class="price_p"><?php echo $total ?></td>
                <td><i class="fa-solid fa-eye-slash show-more"></i></td>
              </tr>
            <?php
            endforeach;
            ?>

          </tbody>
        </table>
      </div>


    <?php
    endif;
    ?>

    <?php
    $id = 0;

    if (!empty($Days1)) :
      foreach ($Days1 as $Day) :
        $id++;
        $total = 0;

        $my_purchases =  getAllFrom(
          'id_product ,products.name,my_purchases.id_purchases, my_purchases.old_price ,SUM(my_purchases.nb_pieces) as total_nb_pieces,SUM(my_purchases.quantity) as total_quantity',
          'my_purchases',
          "my_purchases.date=?",
          $Day['date'],
          'INNER JOIN products ON my_purchases.id_product = products.id',
          "GROUP BY my_purchases.id_product"
        )


    ?>

        <div class="table-container full-info p<?php echo $id ?>">
          <table class="info-table">
            <thead>
              <thead>
                <tr>
                  <td><?php echo lang('product') ?> </td>
                  <td><?php echo lang('quantity') ?></td>
                  <td><?php echo lang('nb_pieces') ?></td>
                  <td><?php echo lang('price') ?></td>
                  <td><?php echo lang('price Total') ?> </td>
                  <td><?php echo lang('delete') ?></td>
                </tr>
              </thead>
            <tbody>
              <?php

              foreach ($my_purchases as $product) :
                $total += $product["old_price"] * $product["total_quantity"];
              ?>

                <tr>
                  <td><?php echo  $product["name"] ?></td>
                  <td><?php echo $product["total_quantity"] ?></td>
                  <td><?php echo $product["total_nb_pieces"] ?></td>
                  <td><?php echo $product["old_price"] ?></td>
                  <td class="price_p"><?php echo  $product["old_price"] * $product["total_quantity"] ?></td>
                  <td>
                    <span>
                      <a href='historyPage.php?do=Delete&id_purchases=<?php echo $product['id_purchases'] . "&cat=purchases" ?>'>
                        <i class="fa-solid fa-trash delete"></i>
                      </a>
                    </span>
                  </td>
                </tr>
              <?php endforeach; ?>
              <tr class="total">
                <td colspan="4">Total Price</td>
                <td class="price_p"><?php echo $total ?></td>
              </tr>
            </tbody>

          </table>
        </div>
    <?php endforeach;
    endif;

    ?>



    <?php
    $id = 0;

    if (!empty($Days2)) :
      foreach ($Days2 as $Day) :
        $id++;
        $total = 0;

        $my_sales =  getAllFrom(
          'id_product ,products.name, my_sales.id_sales,my_sales.old_price ,SUM(my_sales.quantity) as total_quantity',
          'my_sales',
          "my_sales.date=?",
          $Day['date'],
          'INNER JOIN products ON my_sales.id_product= products.id',
          "GROUP BY my_sales.id_product"
        );




    ?>

        <div class="table-container full-info s<?php echo $id ?>">
          <table class="info-table">
            <thead>
              <thead>
                <tr>
                  <td><?php echo lang('product') ?> </td>
                  <td><?php echo lang('nb_pieces') ?> </td>
                  <td><?php echo lang('price') ?></td>
                  <td><?php echo lang('price Total') ?> </td>
                  <td><?php echo lang('delete') ?></td>
                </tr>
              </thead>
            <tbody>
              <?php

              foreach ($my_sales as $product) :
                $total += $product["old_price"] * $product["total_quantity"];
              ?>

                <tr>
                  <td><?php echo  $product["name"] ?></td>
                  <td><?php echo $product["total_quantity"] ?></td>
                  <td><?php echo $product["old_price"] ?></td>
                  <td class="price_p"><?php echo  $product["old_price"] * $product["total_quantity"] ?></td>
                  <td>
                    <span>
                      <a href='historyPage.php?do=Delete&id_sales=<?php echo $product['id_sales'] . "&cat=sales" ?>'>
                        <i class="fa-solid fa-trash delete"></i>
                      </a>
                    </span>
                  </td>
                </tr>
              <?php endforeach; ?>
              <tr class="total">
                <td colspan="4">Total Price</td>
                <td class="price_p"><?php echo $total ?></td>
              </tr>
            </tbody>

          </table>
        </div>
    <?php endforeach;
    endif;

    ?>


    <?php


    $array = $totalSales +  $totalPurchases;
    if (!empty($array)) {
      $price = 0;
      $groupedArray = array();


      foreach ($array as $key => $value) {
        $dateKey = substr($key, 0, 10);
        $groupedArray[$dateKey][] = $value;
      }
      uksort($groupedArray, function ($a, $b) {
        return strtotime($b) - strtotime($a);
      });


      $id = 0;
    ?>

      <div class="table-container table-type profits">
        <table class="info-table">
          <thead>
            <tr>
              <td> <?php echo lang('id') ?> </td>
              <td><?php echo lang('date') ?> </td>
              <td><?php echo lang('price Total') ?></td>
            </tr>
          </thead>
          <tbody>

            <?php

            foreach ($groupedArray as $date => $values) {
              if (count($values) > 1) {
                $price = $values[0] + $values[1];
              } else {
                $price = $values[0];
              }
              $id++;
            ?>
              <tr data-prod="pr<?php echo $id ?>">
                <td><?php echo $id ?></td>
                <td class="date"><?php echo $date ?></td>
                <td class="price_p" style="direction: ltr;"><?php echo  $price    ?></td>
              </tr>

            <?php
            }
            ?>
          </tbody>
        </table>
      </div>


      <div class="chart table-type">
        <input type="month" class="input_date" min="<?php echo substr(min(array_keys($array)), 0, 7) ?>" value="<?php echo substr(max(array_keys($array)), 0, 7) ?>" max="<?php echo substr(max(array_keys($array)), 0, 7) ?>" />

        <canvas id="myChart" width="400" height="200"></canvas>
      </div>

  </div>



<?php



    }













?>





















</div>
<?php include  $tpl . 'footer.php';
?>
</body>

<?php } ?>
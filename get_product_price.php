<?php
include "connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    $page = $_POST['page'];
    $date = substr($_POST['date'],0,10);

    $stmt = $con->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
    $stmt->execute();

    $stmt1 = $con->prepare("SELECT SUM(nb_pieces) as total_pieces FROM my_purchases WHERE date = :date AND id_product = :id_product");
    $stmt1->bindParam(':date', $date, PDO::PARAM_STR);
    $stmt1->bindParam(':id_product', $productId, PDO::PARAM_INT);
    $stmt1->execute();

    // استخدام fetch للحصول على صف واحد من النتيجة
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($page == "productPurchases") {
        echo $product["price"];
    } elseif ($page == "productSales") {
        $totalPieces = ($stmt1->fetch(PDO::FETCH_ASSOC))['total_pieces'];
        echo $product["price_selling"] . "," . $totalPieces ;
    }
}
?>

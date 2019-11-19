<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Производствена фирма</title>
    <link type="text/css" rel="stylesheet" href="style.css">
</head>
<body>

<?php include "db_config.php" ?>

<?php
$collectedSum = 0;
$expectedSum = 0;

// функция, попълваща таблицата и сортира по зададения параметър
function fillTable($orderby) {
    $query = "SELECT * FROM ordered_products_view WHERE 1 ORDER BY $orderby";
	$products = $GLOBALS["db"]->query($query);

	while($product = mysqli_fetch_array($products)) {
		echo '
		<tr>
            <td>'. $product["product_code"] .'</td>
            <td>'. $product["product_name"] .'</td>
            <td>'. $product["pay_type_name"] .'</td>
            <td>'. $product["product_quantity_total"] .'</td>
            <td>'. $product["product_price_total"] .'</td>
		</tr>
        ';
        
        if($product["pay_type_id"]=="1") {
            $GLOBALS["collectedSum"] += $product["product_price_total"];
        }
        elseif($product["pay_type_id"]=="2") {
            $GLOBALS["collectedSum"] += $product["product_price_total"] * 15/100; // 15 процента
        }
        elseif($product["pay_type_id"]=="3") {
            $GLOBALS["expectedSum"] += $product["product_price_total"];
        }
    }
}
?>

<a href="index.php">Поръчани продукти</a>
<a href="clients.php">Клиенти</a>
<a href="products.php">Продукти</a>

<h1>Поръчани продукти</h1>

<table>
    <tr>
        <th><a href="?orderby=code">Код на продукт</a></th>
        <th><a href="?orderby=name">Име на продукт</a></th>
        <th><a href="?orderby=paytype">Вид на плащане</a></th>
        <th><a href="?orderby=product_quantity_total">Брой поръчани</a></th>
        <th><a href="?orderby=pricetotal">Обща цена</a></th>
    </tr>

    <?php
        if(isset($_GET["orderby"]) && $_GET["orderby"] == "name") {
            fillTable("product_name");
        }
        elseif(isset($_GET["orderby"]) && $_GET["orderby"] == "code") {
            fillTable("product_code");
        }
        elseif(isset($_GET["orderby"]) && $_GET["orderby"] == "paytype") {
            fillTable("pay_type_name");
        }
        elseif(isset($_GET["orderby"]) && $_GET["orderby"] == "product_quantity_total") {
            fillTable("product_quantity_total");
        }
        elseif(isset($_GET["orderby"]) && $_GET["orderby"] == "pricetotal") {
            fillTable("product_price_total");
        }  else {
            fillTable("product_id");
        }
    ?>

</table>

<p>Събрама в момента сума: <?php echo $collectedSum ?> лв.</p>
<p>Очакваната сума от дадените на консигнация продукти: <?php echo $expectedSum ?> лв.</p>
<p>Дата: <?php echo date("d.m.Y") ?></p>

</body>
</html>
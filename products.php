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
function fillTable($orderby) {
    $query = "SELECT * FROM products WHERE 1 ORDER BY $orderby";
	$products = $GLOBALS["db"]->query($query);
	
	while($product = mysqli_fetch_array($products)) {
		echo '
		<tr>
            <td>'. $product["id"] .'</td>
            <td>'. $product["code"] .'</td>
            <td>'. $product["name"] .'</td>
            <td>'. $product["price"] .'</td>
            <td>
                <a href="products_form.php?delete='. $product["id"] .'" onClick="return confirm(\'Сигурни ли сте?\')">Изтрий</a> |
                <a href="products_form.php?edit='. $product["id"] .'">Редактирай</a>
            </td>
		</tr>
		';
    }
}
?>

<a href="index.php">Поръчани продукти</a>
<a href="clients.php">Клиенти</a>
<a href="products.php">Продукти</a>

<h1>Продукти</h1>

<a href="products_form.php">Добавяне</a>

<table>
    <tr>
        <th><a href="?orderby=id">Id на продукт</a></th>
        <th><a href="?orderby=code">Код на продукт</a></th>
        <th><a href="?orderby=name">Име на продукт</a></th>
        <th><a href="?orderby=price">Цена на продукт</a></th>
        <th>Действие</th>
    </tr>

    <?php
        if(isset($_GET["orderby"]) && $_GET["orderby"] == "id") {
            fillTable("id");
        }
        elseif(isset($_GET["orderby"]) && $_GET["orderby"] == "code") {
            fillTable("code");
        }
        elseif(isset($_GET["orderby"]) && $_GET["orderby"] == "name") {
            fillTable("name");
        }
        elseif(isset($_GET["orderby"]) && $_GET["orderby"] == "price") {
            fillTable("price");
        } else {
            fillTable("id");
        }
    ?>

</table>

</body>
</html>
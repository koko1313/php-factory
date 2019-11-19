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
    $query = "SELECT * FROM clients_view WHERE 1 ORDER BY $orderby";
    $clients = $GLOBALS["db"]->query($query);

	while($client = mysqli_fetch_array($clients)) {
		echo '
		<tr>
            <td>'. '['. $client["client_id"] .'] '. $client["client_name"] .'</td>
            <td>'. $client["client_type_name"] .'</td>
            <td>'. $client["product_name"] .' ['. $client["product_code"] . ']' .'</td>
            <td>'. $client["product_price"] .'</td>
            <td>'. $client["product_quantity"] .'</td>
            <td>'. $client["total_price"] .'</td>
            <td>
                <a href="clients_form.php?delete='. $client["client_id"] .'" onClick="return confirm(\'Сигурни ли сте?\')">Изтрий</a> |
                <a href="clients_form.php?edit='. $client["client_id"] .'">Редактирай</a>
            </td>
		</tr>
        ';
    }
}
?>

<a href="index.php">Поръчани продукти</a>
<a href="clients.php">Клиенти</a>
<a href="products.php">Продукти</a>

<h1>Клиенти</h1>

<a href="clients_form.php">Добавяне</a>

<table>
    <tr>
        <th><a href="?orderby=client_name">Име</a></th>
        <th><a href="?orderby=client_type">Вид на клиент</a></th>
        <th><a href="?orderby=product_name">Продукт</a></th>
        <th><a href="?orderby=product_price">Единична цена</a></th>
        <th><a href="?orderby=quantity">Количество</a></th>
        <th><a href="?orderby=total_price">Обща цена</a></th>
        <th>Действие</th>
    </tr>

    <?php
        if(isset($_GET["orderby"]) && $_GET["orderby"] == "client_name") {
            fillTable("client_name");
        }
        elseif(isset($_GET["orderby"]) && $_GET["orderby"] == "client_type") {
            fillTable("client_type_name");
        }
        elseif(isset($_GET["orderby"]) && $_GET["orderby"] == "product_name") {
            fillTable("product_name");
        }
        elseif(isset($_GET["orderby"]) && $_GET["orderby"] == "product_price") {
            fillTable("product_price");
        }
        elseif(isset($_GET["orderby"]) && $_GET["orderby"] == "quantity") {
            fillTable("product_quantity");
        }
        elseif(isset($_GET["orderby"]) && $_GET["orderby"] == "total_price") {
            fillTable("total_price");
        } else {
            fillTable("client_id");
        }
    ?>

</table>


</body>
</html>
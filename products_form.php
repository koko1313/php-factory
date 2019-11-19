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
    // глобални променливи, които ще използваме за попълване на формата, ако имаме избран за редакция продукт
    $product_code = "";
    $product_name = "";
    $product_price = "";

    // добавяне
    if(isset($_POST["add_product"])) {
        $code = $_POST["product_code"];
        $name = $_POST["product_name"];
        $price = $_POST["product_price"];

        $query = "INSERT INTO products VALUES (Null, '$code', '$name', '$price')";
        $db->query($query);

        header("location: products.php");
    }

    // изтриване
    if(isset($_GET["delete"])) {
        $id = $_GET["delete"];
        $query = "DELETE FROM products WHERE id='$id'";
        $db->query($query);
        header("location: products.php");
    }

    // редактиране
    if(isset($_GET["edit"])) {
        $id = $_GET["edit"];
        $query = "SELECT * FROM products WHERE id='$id'";
        $product = mysqli_fetch_array($GLOBALS["db"]->query($query));
        $product_code = $product["code"];
        $product_id = $product["id"];
        $product_name = $product["name"];
        $product_price = $product["price"];
    }

    if(isset($_POST["edit_product"])) {
        $id = $_POST["product_id"];
        $code = $_POST["product_code"];
        $name = $_POST["product_name"];
        $price = $_POST["product_price"];

        $query = "UPDATE products SET code='$code', name='$name', price='$price' WHERE id='$id'";
        $db->query($query);

        header("location: products.php");
    }
?>

<a href="index.php">Начало</a>
<a href="products.php">Продукти</a>
<a href="clients.php">Клиенти</a>

<h1>Продукти</h1>

<form method="POST" action="products_form.php">
    <label>Код на продукт: </label>
    <input type="text" name="product_code" value="<?php echo $product_code ?>">

    <label>Име на продукт: </label>
    <input type="text" name="product_name" value="<?php echo $product_name ?>">

    <label>Цена: </label>
    <input type="number" name="product_price" value="<?php echo $product_price ?>">

    <?php if(isset($_GET["edit"])) { ?>
        <input type="hidden" name="product_id" value="<?php echo $product_id ?>">
        <button type="submit" name="edit_product">Редактирай</button>
    <?php } else { ?>
        <button type="submit" name="add_product">Добави</button>
    <?php } ?>
</form>

</body>
</html>
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
    // глобални променливи, които ще използваме за попълване на формата, ако имаме избран за редакция клиент
    $client_name = "";
    $client_type_id = "0";
    $product_id = "0";
    $product_quantity = "";

    // добавяне
    if(isset($_POST["add_client"])) {
        $name = $_POST["client_name"];
        $client_type_id = $_POST["client_type_id"];
        $product_id = $_POST["product_id"];
        $product_quantity = $_POST["product_quantity"];

        $query = "INSERT INTO clients VALUES (Null, '$name', '$client_type_id', '$product_id', '$product_quantity')";
        $db->query($query);

        header("location: clients.php");
    }

    // изтриване
    if(isset($_GET["delete"])) {
        $id = $_GET["delete"];
        $query = "DELETE FROM clients WHERE id='$id'";
        $db->query($query);
        header("location: clients.php");
    }

    // редактиране
    if(isset($_GET["edit"])) {
        $id = $_GET["edit"];
        $query = "SELECT * FROM clients_view WHERE client_id='$id'";
        $client = mysqli_fetch_array($GLOBALS["db"]->query($query));
        $client_id = $client["client_id"];
        $client_name = $client["client_name"];
        $client_type_id = $client["client_type_id"];
        $product_id = $client["product_id"];
        $product_quantity = $client["product_quantity"];
    }

    if(isset($_POST["edit_client"])) {
        $id = $_POST["client_id"];
        $name = $_POST["client_name"];
        $client_type_id = $_POST["client_type_id"];
        $product_id = $_POST["product_id"];
        $product_quantity = $_POST["product_quantity"];

        $query = "UPDATE clients SET name='$name', client_type_id='$client_type_id', product_id='$product_id', product_quantity='$product_quantity' WHERE id='$id'";
        $db->query($query);

        header("location: clients.php");
    }
?>

<a href="index.php">Начало</a>
<a href="products.php">Продукти</a>
<a href="clients.php">Клиенти</a>

<h1>Клиенти</h1>

<form method="POST" action="clients_form.php">
    <label>Име на клиент: </label>
    <input type="text" name="client_name" value="<?php echo $client_name ?>">

    <label>Вид на клиент: </label>
    <select name="client_type_id" id="clientTypeIdSelect">
        <?php
        $query = "SELECT * FROM client_types WHERE 1 ORDER BY id";
        $client_types = $GLOBALS["db"]->query($query);
        
        while($client_type = mysqli_fetch_array($client_types)) {
            echo '<option value="'. $client_type["id"] .'">'. $client_type["type_name"] .'</option>';
        }
        ?>
    </select>

    <label>Продукт: </label>
    <select name="product_id" id="productIdSelect">
        <?php
        $query = "SELECT * FROM products WHERE 1 ORDER BY id";
        $products = $GLOBALS["db"]->query($query);
        
        while($product = mysqli_fetch_array($products)) {
            echo '<option value="'. $product["id"] .'">'. $product["name"] .' - '. $product["price"] .'лв.</option>';
        }
        ?>
    </select>

    <label>Количество: </label>
    <input type="number" name="product_quantity" value="<?php echo $product_quantity ?>">

    <?php if(isset($_GET["edit"])) { ?>
        <input type="hidden" name="client_id" value="<?php echo $client_id ?>">
        <button type="submit" name="edit_client">Редактирай</button>
    <?php } else { ?>
        <button type="submit" name="add_client">Добави</button>
    <?php } ?>
</form>

<script>
    // за селектиране на вид на клиент при редактиране
    var select = document.getElementById("clientTypeIdSelect");
    select.value = "<?php echo $client_type_id ?>";

    // за селектиране на продукт при редактиране
    var select = document.getElementById("productIdSelect");
    select.value = "<?php echo $product_id ?>";
</script>

</body>
</html>
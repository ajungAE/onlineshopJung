<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produktdetails</title>
</head>
<body>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once("getProductView.php"); //wiederverwendbare Produkt-Funktion


// Warenkorb-Handling wie bisher
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $found = false;
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $product_id) {
            $_SESSION['cart'][$key]['quantity']++;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $product_id,
            'name' => $product_name,
            'price' => $product_price,
            'quantity' => 1
        ];
        echo "<p style='color:green;'>Produkt wurde erfolgreich zum Warenkorb hinzugefügt.</p>";
    }
}
?>

<?php require_once("templates/login.php"); ?>
<h1>Onlineshop - Produktdetails</h1>
<?php require_once("templates/navigation.php"); ?>

<?php

// Produktdetails anzeigen (aus JSON)
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $jsonData = file_get_contents("products.json");
    $products = json_decode($jsonData, true);

    $produktGefunden = false;

    foreach ($products as $product) {
        if ($product['id'] == $id || $product['id'] == (int)$id) {
            getProductView($product, isset($_SESSION['eingeloggt']), true);
            $produktGefunden = true;
            break;
        }
    }

    if (!$produktGefunden) {
        echo "<p style='color:red;'>Produkt wurde nicht gefunden.</p>";
    }
} else {
    echo "<p style='color:red;'>Keine Produkt-ID angegeben.</p>";
}
?>

<?php require_once("templates/footer.php"); ?>

</body>
</html>

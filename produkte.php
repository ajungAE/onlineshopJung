<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Onlineshop - Produkte</title>
</head>

<body>

<?php
session_start();


// Warenkorb-Handling: Produkt hinzufügen
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


// Funktion: Produkt als HTML anzeigen
require_once("getProductView.php");

// Login-Formular
require_once("templates/login.php"); ?>

<h1>Onlineshop - Produkte</h1>
<?php require_once("templates/navigation.php"); ?>

<?php

// Produkte aus JSON laden
$jsonData = file_get_contents("products.json");

if ($jsonData === false) {
    die("<p style='color:red;'>Fehler beim Laden der Produktdaten.</p>");
}

$products = json_decode($jsonData, true);

if ($products === null) {
    die("<p style='color:red;'>Fehler beim Verarbeiten der JSON-Daten.</p>");
}


// Produkte dynamisch anzeigen
foreach ($products as $product) {
    getProductView($product, isset($_SESSION['eingeloggt']), true);
}
?>

<?php require_once("templates/footer.php"); ?>

</body>
</html>

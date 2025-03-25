<?php
// Funktion: Produkt als HTML anzeigen
function getProductView($product, $eingeloggt = false,$showImage = false) {
    echo "<div style='margin-bottom:30px;'>";

    // Produktname verlinkt zur Detailseite
    echo "<h2><a href='produkt_detail.php?id=" . urlencode($product['id']) . "'>" 
        . htmlspecialchars($product['name']) . "</a></h2>";

    // Bild
    if ($showImage) {
        echo "<img src='" . htmlspecialchars($product['image']) . "' alt='Produktbild' style='max-width:300px;'>";
    }
    // Beschreibung
    echo "<p>" . htmlspecialchars($product['description']) . "</p>";

    // Preis mit zwei Nachkommastellen
    echo "<p>Preis: " . number_format($product['price'], 2, ',', '.') . " €</p>";

    // Formular zum "In den Warenkorb" legen (nur wenn eingeloggt)
    if ($eingeloggt) {
        echo "<form action='produkte.php' method='POST'>";
        echo "<input type='hidden' name='product_id' value='" . htmlspecialchars($product['id']) . "'>";
        echo "<input type='hidden' name='product_name' value='" . htmlspecialchars($product['name']) . "'>";
        echo "<input type='hidden' name='product_price' value='" . htmlspecialchars($product['price']) . "'>";
        echo "<button name='add_product' type='submit'>In den Warenkorb</button>";
        echo "</form>";
    }

    echo "</div>";
}
?>
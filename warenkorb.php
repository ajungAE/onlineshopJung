<!-- HTML5-Dokumenttyp deklarieren -->
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Zeichencodierung auf UTF-8 setzen -->
    <meta charset="UTF-8">
    <!-- Viewport für responsives Design -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Seitentitel -->
    <title>Document</title>
</head>
<body>
    <?php
        // Session starten, um Zugriff auf Sitzungsdaten zu erhalten
        session_start();

        /* Funktion zum Entfernen eines Produkts zum Warenkorb
        -alter Lösungsansatz
        function removeProduct($product_id) {
            if (isset($_SESSION['cart'][$product_id])) {
                unset($_SESSION['cart'][$product_id]); // Produkt aus dem Warenkorb entfernen
                echo "Produkt wurde entfernt.<br>"; // Bestätigungsausgabe
            }
        }*/
        function removeProduct($product_id) {
            if (!isset($_SESSION['cart'])) return;
        
            foreach ($_SESSION['cart'] as $key => $item) {
                if ($item['id'] == $product_id) { // Produkt mit passender ID finden
                    unset($_SESSION['cart'][$key]); // Produkt entfernen
                    $_SESSION['cart'] = array_values($_SESSION['cart']); // Indizes neu ordnen
                    echo "Produkt wurde entfernt.<br>"; // Debugging-Ausgabe
                    return;
                }
            }
        }
        

        /* Überprüfen, ob das Formular mit der POST-Methode gesendet wurde und ob der Entfernen-Button gedrückt wurde
        - alter Lösungsansatz
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove'])) {
            removeProduct($_POST['product_id']);// Produkt entfernen
        }*/

        // Überprüfen, ob das Formular mit der POST-Methode gesendet wurde und ob eine Produkt-ID vorhanden ist
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove'])) {
            if (isset($_POST['product_id'])) {
                removeProduct($_POST['product_id']); // Produkt entfernen
            }
        }
        
        

        // Überprüfen, ob das Formular mit der POST-Methode gesendet wurde und ob eine Produkt-ID vorhanden ist
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
            $product_id = $_POST['product_id']; // Produkt-ID aus dem Formular erhalten

            // Erhöhen der Produktmenge im Warenkorb
            if(isset($_POST['increase_quantity'])) {
                foreach ($_SESSION['cart'] as $key => $item) { // Durch den Warenkorb iterieren
                    if ($item['id'] == $product_id) { // Passende Produkt-ID suchen
                        $_SESSION['cart'][$key]['quantity']++; // Menge um 1 erhöhen
                        break; // Schleife abbrechen, wenn Produkt gefunden wurde
                    }
                }
            }

            // Verringern der Produktmenge im Warenkorb
            if(isset($_POST['decrease_quantity'])) {
                foreach ($_SESSION['cart'] as $key => $item) { // Durch den Warenkorb iterieren
                    if ($item['id'] == $product_id) { // Passende Produkt-ID suchen
                        if ($_SESSION['cart'][$key]['quantity'] > 1) { // Menge darf nicht unter 1 fallen
                            $_SESSION['cart'][$key]['quantity']--; // Menge um 1 verringern
                        } else {
                            removeProduct($product_id); // Produkt entfernen, wenn Menge 1 ist
                        }
                        break; 

                    }
                }
            }
        }

        // Überprüfen, ob der Benutzer den Warenkorb leeren möchte
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['clear_cart'])) {
            unset($_SESSION['cart']); // Warenkorb aus der Session entfernen
            echo "Der Warenkorb wurde geleert.<br>"; // Bestätigungsausgabe
        }
    ?>

    <!-- Login-Skript einbinden -->
    <?php require_once("login.php"); ?>

    <h1>Onlineshop - Warenkorb</h1>
    
    <!-- Navigationsleiste einbinden -->
    <?php require_once("templates/navigation.php"); ?>

    <?php
        // Überprüfen, ob der Warenkorb existiert und Produkte enthält
        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
            echo "<h1>Warenkorb von {$_SESSION['username']}</h1>"; // Benutzername ausgeben
            echo "<ul>"; // Liste für Produkte öffnen

            foreach ($_SESSION['cart'] as $item) { // Jedes Produkt im Warenkorb durchgehen
                echo "<li>";
                echo "Produkt: " . htmlspecialchars($item['name']); // Produktname ausgeben
                echo " - Preis: " . htmlspecialchars($item['price']) . " €"; // Preis ausgeben
                echo " - Anzahl: " . $item['quantity']; // Menge ausgeben

                ?>

                <!-- Formular zur Mengenänderung eines Produkts -->
                <form action="warenkorb.php" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $item["id"] ?>">
                    <button type="submit" name="increase_quantity">+</button>
                    <button type="submit" name="decrease_quantity">-</button>
                    <button type="submit" name="remove">Entfernen</button><!-- Entfernen-Button hinzufügen -->
                </form>

                <?php
                echo "</li>";
            }
            echo "</ul>";

            // Gesamtkosten berechnen
            $total_cost = 0;
            if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                foreach ($_SESSION['cart'] as $item) {
                    $total_cost += $item['price'] * $item['quantity']; // Preis * Menge addieren
                }

                echo "<p>Gesamtkosten: " . number_format($total_cost, 2) . " €</p>"; // Formatierte Gesamtkosten ausgeben
            }
            ?>

            <!-- Formular zum Leeren des Warenkorbs -->
            <form action="warenkorb.php" method="POST">
                <button type="submit" name="clear_cart">Warenkorb leeren</button>
            </form>

            <?php
        } else {
            // Falls der Warenkorb leer ist, entsprechende Meldung ausgeben
            echo "<p>Ihr Warenkorb ist leer.</p>";
        }
    ?>

    <!-- Footer einbinden -->
    <?php require_once("templates/footer.php"); ?>

</body>
</html>

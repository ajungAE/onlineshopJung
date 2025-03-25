# mini-onlineshop-jung

Ein einfacher PHP-Onlineshop zum Üben von Webentwicklung und Git-Versionierung.  
Der Shop besteht aus mehreren Seiten, die modular über Templates eingebunden werden. Produkte, Navigation, Login, Warenkorb und eine Detailansicht sind enthalten.

---

## Projektstruktur 

```
.
├── index.php
├── login.php
├── produkte.php
├── produkt_detail.php
├── warenkorb.php
├── kontakt.php
├── ueber-uns.php
├── cart-widget.php
├── templates/
│   ├── navigation.php
│   └── footer.php
├── images/
│   ├── besen.jpg
│   ├── fruchtbonbons.jpg
│   └── zahncreme.jpg
```

---

## Voraussetzungen

- PHP (mind. Version 7)
- Lokaler Webserver oder PHP-Built-in Server
- Git (für Versionskontrolle)

---

## Installation und Start

1. Repository klonen:

   ```bash
   git clone https://github.com/FI-37/mini-onlineshop-jung.git
   cd mini-onlineshop-jung
   ```

2. Starte den lokalen Webserver:

   ```bash
   php -S localhost:8000
   ```

3. Öffne den Browser:

   ```
   http://localhost:8000/index.php
   ```

---

## Funktionen

- Navigation via Template
- Startseite und statische Seiten (über uns, Kontakt)
- Produktübersicht und Detailansicht
- Statischer Loginbereich
- Warenkorb-Widget (noch nicht funktional)
- Bildmaterial im images-Ordner

---

## Nächste Schritte (Vorschläge)

- Session-Handling für den Warenkorb
- Produkte aus Datei oder Datenbank laden
- Login mit echter Benutzerprüfung
- Styling mit CSS
- Responsives Layout

---

## Autor

**ajungAE**  
Lernprojekt im Rahmen der Webentwicklung (Mini-Onlineshop mit PHP & Git)

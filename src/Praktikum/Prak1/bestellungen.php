<?php
$html = <<<HTML
<!DOCTYPE html>
<html lang="de">  
<head>
    <meta charset="UTF-8">
    <title>Bestellseite</title>
</head>
<body>
    <header>
        <h1>Willkommen beim Pizzaservice</h1>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Speisekarte</a></li>
                <li><a href="#">Bestellen</a></li>
                <li><a href="#">Kontakt</a></li>
            </ul>
        </nav>
    </header>
    <section id="bestellung">
        <h2>Bestellung aufgeben</h2>
        <form action="https://echo.fbi.h-da.de/" method="post">
            <label for="pizza">Pizza wählen:</label>
            <select id="pizza" name="pizza[]" multiple>
                <option value="salami">Salami-Pizza</option>
                <option value="margherita">Margherita</option>
                <option value="vegetariana">Vegetariana</option>
            </select>
            <div class="pizza-option">
                <img id='salami' src='Pizza.jpeg' alt='Salami Pizza Bild' style='display:block; width:100px; height:100px;'>
                <p>Salami-Pizza - 4.50 €</p>
            </div>
            <div class="pizza-option">
                <img id='margherita' src='Pizza.jpeg' alt='Margherita Pizza Bild' style='display:block; width:100px; height:100px;'>
                <p>Margherita - 4.00 €</p>
            </div>
            <div class="pizza-option">
                <img id='hawaii' src='Pizza.jpeg' alt='Hawaii Pizza Bild' style='display:block; width:100px; height:100px;'>
                <p>Hawaii - 5.50 €</p>
            </div>
            <br>
            <label>Größe wählen:</label>
            <input type="radio" id="small" name="size" value="small">
            <label for="small">Klein</label>
            <input type="radio" id="medium" name="size" value="medium">
            <label for="medium">Mittel</label>
            <input type="radio" id="large" name="size" value="large">
            <label for="large">Groß</label>
            <br>
            <label>Extras wählen:</label>
            <input type="checkbox" id="cheese" name="extras[]" value="cheese">
            <label for="cheese">Käse</label>
            <input type="checkbox" id="mushrooms" name="extras[]" value="mushrooms">
            <label for="mushrooms">Champignons</label>
            <input type="checkbox" id="pepperoni" name="extras[]" value="pepperoni">
            <label for="pepperoni">Pepperoni</label>
            <br>
            <label for="quantity">Anzahl:</label>
            <input type="number" id="quantity" name="quantity" min="1" max="10" value="1">
            <br>
            <input type="submit" value="Bestellen">
        </form>
    </section>
    <footer>
        <p>© 2024 Pizzaservice</p>
    </footer>
</body>
</html>
HTML;

echo $html;
?>

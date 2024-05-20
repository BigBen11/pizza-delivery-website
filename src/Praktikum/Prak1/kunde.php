<?php
$html = <<<HTML
<!DOCTYPE html>
<html lang="de">  
<head>
    <meta charset="UTF-8">
    <title>Kunden-Seite</title>
</head>
<body>
    <header>
        <h1>Willkommen beim Pizzaservice, lieber Kunde!</h1>
        <nav>
            <ul>
                <li><a href="bestellungen.php">Bestellungen</a></li>
                <li><a href="baecker.php">Bäcker</a></li>
                <li><a href="fahrer.php">Fahrer</a></li>
            </ul>
        </nav>
    </header>
    <section id="bestellungen">
        <h2>Kunde (Lieferstatus)</h2>
        <ul>
            <li>Margherita: bestellt</li>
            <li>Salami: Im Ofen</li>
            <li>Tonno: fertig</li>
            <li>Hawai: bestellt</li>
        </ul>
        
    </section>
    <footer>
        <p>© 2024 Pizzaservice</p>
    </footer>
</body>
</html>
HTML;

echo $html;
?>

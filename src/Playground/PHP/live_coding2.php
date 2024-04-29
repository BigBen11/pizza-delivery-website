<?php
// MIME-Type der Antwort definieren (*vor* allem HTML):
header("Content-type: text/html");
// alle möglichen Fehlermeldungen aktivieren:
error_reporting(E_ALL);

echo <<< HTML
    <!DOCTYPE html>
    <html lang="de">  
    <head>
        <meta charset="UTF-8" />
        <!-- für später: CSS include -->
        <!-- <link rel="stylesheet" href="XXX.css"/> -->
        <!-- für später: JavaScript include -->
        <!-- <script src="XXX.js"></script> -->
        <title>Text des Titels</title>
    </head>
HTML;


$pizzas = [
    0 =>[
        'name' => 'Margherita',
        'preis' => '9.00 €',
        'foto' => 'pizza_foto.jpg'
    ],
    1 =>[
        'name' => 'Salami',
        'preis' => '12.50 €',
        'foto' => 'pizza_foto.jpg'
    ],
    2 =>[
        'name' => 'Hawaii',
        'preis' => '13.00 €',
        'foto' => 'pizza_foto.jpg'
    ],
];

echo <<< HTML

    <body>
        <section> <b>Bestellung</b> </section>
        
        <hr/> <!-- später in CSS implementieren! -->

        <article> <b>Speisekarte</b> </article>
    
HTML;


foreach ($pizzas as $pizza) {
    echo '<div>';
    echo '<img src=' . $pizza['foto'] . ' alt="Margherita" width="90" height="100"/>';
    echo '<div>' . $pizza['name'] . '</div>';
    echo '<div>' . $pizza['preis'] . '</div>';
    echo '</div>';
}


echo <<< HTML

        </br> <!-- später in CSS implementieren! -->

        <article> <b>Warenkorb</b> </article>

        <form action="http://localhost/Playground/PHP/live_coding2.php" method="get" accept-charset="UTF-8">
            <fieldset>
                <legend>Bitte wählen Sie aus</legend>

                <select name="Pizza_type" id="Pizza_type" size="5" onchange="alert(this.form.XXX.options[this.form.XXX.selectedIndex].value)">
                    <option value="1"> Margherita </option>
                    <option value="2"> Salami </option>
                    <option value="3"> Hawaii </option>
                </select>
            </fieldset>

            </br> <!-- später in CSS implementieren! -->

            <input type="text" name="Adresse" placeholder="Ihre Adresse"/>

            </br> <!-- später in CSS implementieren! -->
            </br> <!-- später in CSS implementieren! -->

            <input type="reset" name="Alle_löschen" value="Alle löschen"/>
            <input type="reset" name="Auswahl_löschen" value="Auswahl löschen"/>
            <input type="submit" id="B1" name="Bestellen" value="Bestellen"/>
        </form>
    </body>
    </html>

HTML;

?>
<?php declare(strict_types=1);
require_once './Page.php';

class Bestellung extends Page
{
    protected function __construct()
    {
        parent::__construct();
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    protected function processReceivedData():void
    {

        parent::processReceivedData();
    }

    protected function getViewData():array
    {

       return array();
    }

    protected function generateView():void
{
    $data = $this->getViewData();

    $this->generatePageHeader('Bestellung'); 

    echo <<<HTML
        <h1> <b>Bestellung</b> </h1>
        
        <hr> <!-- später in CSS implementieren! -->

        <h2> <b>Speisekarte</b> </h2>
        
        <div>
            <img src="pizza_foto.jpg" alt="Margherita" width="90" height="100">
            <div> Margherita </div>
            <div> 9.00 € </div>
        </div>

        <div>
            <img src="pizza_foto.jpg" alt="Salami" width="90" height="100">
            <div> Salami </div>
            <div> 12.50 € </div>
        </div>

        <div>
            <img src="pizza_foto.jpg" alt="Hawaii" width="90" height="100">
            <div> Hawaii </div>
            <div> 13.00 € </div>
        </div>

        <br> <!-- später in CSS implementieren! -->

        <h2> <b>Warenkorb</b> </h2>

        <form id="myForm" accept-charset="UTF-8" action="https://echo.fbi.h-da.de/" method="post">

            <fieldset>
                <legend>Bitte wählen Sie aus</legend>

                <select name="Pizza_type[]" id="Pizza_type" size="5" multiple>
                    <option value="1"> Margherita </option>
                    <option value="2"> Salami </option>
                    <option value="3"> Hawaii </option>
                </select>
            </fieldset>

            <br> <!-- später in CSS implementieren! -->

            <input type="text" name="Adresse" placeholder="Ihre Adresse">

            <br> <!-- später in CSS implementieren! -->
            <br> <!-- später in CSS implementieren! -->

            <input type="reset" name="Alle_löschen" value="Alle löschen">
            <input type="reset" name="Auswahl_löschen" value="Auswahl löschen">
            <input type="submit" id="B1" name="Bestellen" value="Bestellen">
        </form>
    HTML;

    $this->generatePageFooter();
}


    public static function main():void
    {
        try {
            $page = new Bestellung();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/html; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

// This call is starting the creation of the page. 
Bestellung::main();


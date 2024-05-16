<?php declare(strict_types=1);
require_once './Page.php';

class Kunde extends Page
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
        $pizza_states["Margherita"] = "Bestellt";
        $pizza_states["Salami"] = "Bestellt";
        $pizza_states["Hawaii"] = "Im Ofen";

       return $pizza_states;
    }

    protected function generateView():void {

        $pizza_states = $this->getViewData();

        $this->generatePageHeader('Kunde'); 

        echo <<< HTML
            <h1> <b>Kunde (Lieferstatus)</b> </h1>
            <hr> <!-- später in CSS implementieren! -->
        HTML;

        echo "<ul>";
        foreach ($pizza_states as $pizza => $state){
            echo "<li>" . $pizza . ": " . $state . "</li>";
        } 
        echo "</ul>";

        echo <<< HTML
            <a href="./bestellung.php">
            <button>Neue Bestellung</button>
            </a>

        HTML;

        $this->generatePageFooter();
    }


    public static function main():void
    {
        try {
            $page = new Kunde();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/html; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

// This call is starting the creation of the page. 
Kunde::main();


<?php declare(strict_types=1);
require_once './Page.php';

class Fahrer extends Page
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

    $this->generatePageHeader('Fahrer'); 

    echo <<< HTML
        <h1> <b>Fahrer (auslieferbare Bestellungen)</b> </h1>
        <hr> <!-- später in CSS implementieren! -->

        <p>1.Bestellt   2.Im Ofen   3.Fertig</p>
        <label>
            <input type="radio" id="radioGet" checked name="R2" value="get"/>
            <input type="radio" id="radioGet" checked name="R2" value="get"/>
            <input type="radio" id="radioGet" checked name="R2" value="get"/>
            Margherita
        </label>

        <br>

        <label>
            <input type="radio" id="radioGet" checked name="R2" value="get"/>
            <input type="radio" id="radioGet" checked name="R2" value="get"/>
            <input type="radio" id="radioGet" checked name="R2" value="get"/>
            Salami
        </label>

        <br>

        <label>
            <input type="radio" id="radioGet" checked name="R2" value="get"/>
            <input type="radio" id="radioGet" checked name="R2" value="get"/>
            <input type="radio" id="radioGet" checked name="R2" value="get"/>
            Hawaii
        </label>

    HTML;

    $this->generatePageFooter();
}


    public static function main():void
    {
        try {
            $page = new Fahrer();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/html; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

// This call is starting the creation of the page. 
Fahrer::main();


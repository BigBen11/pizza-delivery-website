<?php declare(strict_types=1);
require_once './Page.php';

class Baecker extends Page
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

    $this->generatePageHeader('Bäcker'); 

    echo <<< HTML
        <h1> <b>Pizzabäcker (bestellte Pizzen)</b> </h1>
        <hr> <!-- später in CSS implementieren! -->

        <p>1.Bestellt   2.Im Ofen   3.Fertig</p>
        <label>
            <input type="radio" id="bestellt_m" checked name="margherita" value="get"/>
            <input type="radio" id="im_ofen_m" checked name="margherita" value="get"/>
            <input type="radio" id="fertig_m" checked name="margherita" value="get"/>
            Margherita
        </label>

        <br>

        <label>
            <input type="radio" id="bestellt_s" checked name="salami" value="get"/>
            <input type="radio" id="im_ofen_s" checked name="salami" value="get"/>
            <input type="radio" id="fertig_s" checked name="salami" value="get"/>
            Salami
        </label>

        <br>

        
        <label>
            <input type="radio" id="bestellt_h" checked name="hawaii" value="get"/>
            <input type="radio" id="im_ofen_h" checked name="hawaii" value="get"/>
            <input type="radio" id="fertig_h" checked name="hawaii" value="get"/>
            Hawaii
        </label>
    HTML;


    $this->generatePageFooter();
}


    public static function main():void
    {
        try {
            $page = new Baecker();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/html; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

// This call is starting the creation of the page. 
Baecker::main();


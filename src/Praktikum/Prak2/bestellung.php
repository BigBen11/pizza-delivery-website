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
        
        $sql = "SELECT * FROM pizzaservice.article ORDER BY article_id ASC";
        $recordset = $this->db->query($sql);

        if (!$recordset) {
            throw new Exception("Abfrage fehlgeschlagen: " . $this->db->error);
        }

        $articles = [];

        // Read selected records into result array
        while ($record = $recordset->fetch_assoc()) {
            // article_id as the key and the other attributes as values
            $articles[$record['article_id']] = [
                'name' => $record['name'],
                'picture' => $record['picture'],
                'price' => $record['price']
            ];
        }

        //var_dump($articles);

        $recordset->free();
        


       return $articles;
    }

    protected function generateView():void {

        $articles = $this->getViewData();
    
        $this->generatePageHeader('Bestellung'); 
    
        echo <<<HTML
            <h1> <b>Bestellung</b> </h1>
            
            <hr> <!-- später in CSS implementieren! -->
    
            <h2> <b>Speisekarte</b> </h2>
        HTML;
    
        // Generate the HTML for each pizza
        foreach ($articles as $article_id => $article) {
            echo <<<HTML
                <div>
                    <img src="{$article['picture']}" alt="{$article['name']}" width="90" height="100">
                    <div> {$article['name']} </div>
                    <div> {$article['price']} € </div>
                </div>
            HTML;
        }
    
        echo <<<HTML
            <br> <!-- später in CSS implementieren! -->
    
            <h2> <b>Warenkorb</b> </h2>
    
            <form id="myForm" accept-charset="UTF-8" action="https://echo.fbi.h-da.de/" method="post">
    
                <fieldset>
                    <legend>Bitte wählen Sie aus</legend>
    
                    <select name="Pizza_type[]" id="Pizza_type" size="5" multiple>
        HTML;
    
        // Generate the options for each pizza
        foreach ($articles as $article_id => $article) {
            echo <<<HTML
                        <option value="{$article_id}"> {$article['name']} </option>
            HTML;
        }
    
        echo <<<HTML
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


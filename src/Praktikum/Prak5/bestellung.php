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

    protected function processReceivedData(): void
    {
        parent::processReceivedData();


        if (isset($_POST['warenkorb'])) {
            $pizzaIds = $_POST['warenkorb'];
            $address = $_POST['Adresse'];

            
            
            // Prepared Statement für die Bestellung
            $query = "INSERT INTO `ordering` (`address`) VALUES (?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $address);
            $stmt->execute();
            $orderingId = $stmt->insert_id;
            $stmt->close();

            // Speichern der Bestellungs-ID in der Session
            $_SESSION['orderingId'] = $orderingId;

            // Einfügen der bestellten Pizzen
            foreach ($pizzaIds as $pizzaId) {
                $query = "INSERT INTO `ordered_article` (`ordering_id`, `article_id`, `status`) VALUES (?, ?, 1)";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('ii', $orderingId, $pizzaId);
                $stmt->execute();
                $stmt->close();
            }

            // Weiterleitung zur Bestellseite
            header('Location: bestellung.php');
            die;
        }
    }

    protected function getViewData(): array
    {
        $query = "SELECT * FROM `article` ORDER BY `article_id` ASC";
        $result = $this->db->query($query);
        $pizzas = [];

        while ($row = $result->fetch_assoc()) {
            $pizzas[] = $row;
        }
        $result->free();

        return $pizzas;
    }

    protected function generateView(): void
{
    $pizzas = $this->getViewData();
    $this->generatePageHeader('Bestellung', 'bestellung.js'); // Ensure the JS file is included here

    echo <<<HTML
    <h1> <b>Bestellung</b> </h1>

    <h2> <b>Speisekarte</b> </h2>
    <div class="speisekarte-and-form">
        
        <div class="speisekarte">
            
HTML;

    foreach ($pizzas as $pizza) {
        $id = htmlspecialchars($pizza['article_id']);
        $name = htmlspecialchars($pizza['name']);
        $picture = htmlspecialchars($pizza['picture']);
        $price = htmlspecialchars($pizza['price']);
        $price = number_format((float)$price, 2);

        echo <<<HTML
            <div class="pizza-item">
                <img class="pizza-item img" src="$picture" data-name="$name" data-price="$price" data-id="$id"
                width="90" height="100" onclick="addPizza(this)" alt="$name">
                <div> $name </div>
                <div> $price € </div>
            </div>
        HTML;
    }

    echo <<<HTML
            </div>

            <div class="form">

                <h2> <b>Warenkorb</b> </h2>

                <form id="myForm" accept-charset="UTF-8" action="bestellung.php" method="post">
                    <fieldset class="warenkorb-fieldset" id="warenkorb-fieldset">
                        <select tabindex="4" name="warenkorb[]" id="warenkorb" size="5" style="min-width: 200px;" multiple></select>
                        <h2>Preis</h2>
                        <p id="preisAusgabe">0.00€</p>
                    </fieldset>

                    <input type="text" id="address_field" name="Adresse" placeholder="Ihre Adresse" required>

                    <input type="reset" class="bestellung-buttons" name="Alle_löschen" value="Alle löschen">
                    <input type="reset" class="bestellung-buttons" name="Auswahl_löschen" value="Auswahl löschen">
                    <input type="submit" class="bestellung-button-submit" id="submit" name="Bestellen" value="Bestellen" disabled>
                </form>

            </div>

        </div>
HTML;

    $this->generatePageFooter();
}

    public static function main(): void
    {
        try {
            session_start();
            $page = new Bestellung();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/html; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

Bestellung::main();
?>
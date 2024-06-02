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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pizzaIds = $_POST['Pizza_type'];
            $address = $_POST['Adresse'];

            $query = "INSERT INTO `orders` (`address`) VALUES (?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $address);
            $stmt->execute();
            $orderId = $stmt->insert_id;
            $stmt->close();

            foreach ($pizzaIds as $pizzaId) {
                $query = "INSERT INTO `order_items` (`order_id`, `pizza_id`, `status`) VALUES (?, ?, 'Bestellt')";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('ii', $orderId, $pizzaId);
                $stmt->execute();
                $stmt->close();
            }
        }
    }

    protected function getViewData():array
    {
        $query = "SELECT * FROM `pizzas` ORDER BY `id` ASC";
        $result = $this->db->query($query);
        $pizzas = [];

        while ($row = $result->fetch_assoc()) {
            $pizzas[] = $row;
        }
        $result->free();

        return $pizzas;
    }

    protected function generateView():void
    {
        $pizzas = $this->getViewData();

        $this->generatePageHeader('Bestellung'); 

        echo <<<HTML
        <h1> <b>Bestellung</b> </h1>
        <hr>
        <h2> <b>Speisekarte</b> </h2>
HTML;

        foreach ($pizzas as $pizza) {
            $id = htmlspecialchars($pizza['id']);
            $name = htmlspecialchars($pizza['name']);
            $picture = htmlspecialchars($pizza['picture']);
            $price = htmlspecialchars($pizza['price']);

            echo <<<HTML
            <div>
                <img src="$picture" alt="$name" width="90" height="100">
                <div> $name </div>
                <div> $price € </div>
            </div>
HTML;
        }

        echo <<<HTML
        <br>
        <h2> <b>Warenkorb</b> </h2>
        <form id="myForm" accept-charset="UTF-8" action="bestellung.php" method="post">
            <fieldset>
                <legend>Bitte wählen Sie aus</legend>
                <select name="Pizza_type[]" id="Pizza_type" size="5" multiple>
HTML;

        foreach ($pizzas as $pizza) {
            $id = htmlspecialchars($pizza['id']);
            $name = htmlspecialchars($pizza['name']);

            echo <<<HTML
                    <option value="$id"> $name </option>
HTML;
        }

        echo <<<HTML
                </select>
            </fieldset>
            <br>
            <input type="text" name="Adresse" placeholder="Ihre Adresse">
            <br><br>
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

Bestellung::main();
?>

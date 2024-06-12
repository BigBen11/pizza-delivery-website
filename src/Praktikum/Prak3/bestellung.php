<?php declare(strict_types=1);
require_once './Page.php';

session_start();

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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pizzaIds = $_POST['Pizza_type'];
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
        $this->generatePageHeader('Bestellung');

        echo <<<HTML
        <h1> <b>Bestellung</b> </h1>
        <hr>
        <h2> <b>Speisekarte</b> </h2>
HTML;

        foreach ($pizzas as $pizza) {
            $id = htmlspecialchars($pizza['article_id']);
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
            $id = htmlspecialchars($pizza['article_id']);
            $name = htmlspecialchars($pizza['name']);

            echo <<<HTML
                    <option value="$id"> $name </option>
HTML;
        }

        echo <<<HTML
                </select>
            </fieldset>
            <br>
            <input type="text" name="Adresse" placeholder="Ihre Adresse" required>
            <br><br>
            <input type="reset" name="Alle_löschen" value="Alle löschen">
            <input type="reset" name="Auswahl_löschen" value="Auswahl löschen">
            <input type="submit" id="B1" name="Bestellen" value="Bestellen">
        </form>
HTML;

        $this->generatePageFooter();
    }

    public static function main(): void
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
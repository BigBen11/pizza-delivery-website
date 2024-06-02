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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($_POST['status'] as $pizzaId => $status) {
                $query = "UPDATE `order_items` SET `status` = ? WHERE `id` = ?";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('si', $status, $pizzaId);
                $stmt->execute();
                $stmt->close();
            }
        }
    }

    protected function getViewData():array
    {
        $query = "SELECT `order_items`.`id`, `pizzas`.`name`, `order_items`.`status` 
                  FROM `order_items` 
                  JOIN `pizzas` ON `order_items`.`pizza_id` = `pizzas`.`id`";
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
        $data = $this->getViewData();

        $this->generatePageHeader('Bäcker'); 

        echo <<<HTML
        <h1> <b>Pizzabäcker (bestellte Pizzen)</b> </h1>
        <hr>
        <p>1. Bestellt   2. Im Ofen   3. Fertig</p>
        <form method="post" action="baecker.php">
HTML;

        foreach ($data as $pizza) {
            $id = htmlspecialchars($pizza['id']);
            $name = htmlspecialchars($pizza['name']);
            $status = htmlspecialchars($pizza['status']);

            $checkedBestellt = $status == 'Bestellt' ? 'checked' : '';
            $checkedImOfen = $status == 'Im Ofen' ? 'checked' : '';
            $checkedFertig = $status == 'Fertig' ? 'checked' : '';

            echo <<<HTML
            <label>
                <input type="radio" name="status[$id]" value="Bestellt" $checkedBestellt/> Bestellt
                <input type="radio" name="status[$id]" value="Im Ofen" $checkedImOfen/> Im Ofen
                <input type="radio" name="status[$id]" value="Fertig" $checkedFertig/> Fertig
                $name
            </label>
            <br>
HTML;
        }

        echo <<<HTML
            <input type="submit" value="Aktualisieren">
        </form>
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

Baecker::main();
?>

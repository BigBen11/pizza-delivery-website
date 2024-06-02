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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($_POST['status'] as $orderId => $status) {
                $query = "UPDATE `orders` SET `status` = ? WHERE `id` = ?";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('si', $status, $orderId);
                $stmt->execute();
                $stmt->close();
            }
        }
    }

    protected function getViewData():array
    {
        $query = "SELECT `orders`.`id`, `orders`.`status`, `customers`.`name` AS customer_name 
                  FROM `orders` 
                  JOIN `customers` ON `orders`.`customer_id` = `customers`.`id` 
                  WHERE `orders`.`status` = 'Fertig'";
        $result = $this->db->query($query);
        $orders = [];

        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        $result->free();

        return $orders;
    }

    protected function generateView():void
    {
        $data = $this->getViewData();

        $this->generatePageHeader('Fahrer'); 

        echo <<<HTML
        <h1> <b>Fahrer (auslieferbare Bestellungen)</b> </h1>
        <hr>
        <p>1. Bestellt   2. Im Ofen   3. Fertig   4. Unterwegs</p>
        <form method="post" action="fahrer.php">
HTML;

        foreach ($data as $order) {
            $id = htmlspecialchars($order['id']);
            $status = htmlspecialchars($order['status']);
            $customerName = htmlspecialchars($order['customer_name']);

            $checkedFertig = $status == 'Fertig' ? 'checked' : '';
            $checkedUnterwegs = $status == 'Unterwegs' ? 'checked' : '';

            echo <<<HTML
            <label>
                <input type="radio" name="status[$id]" value="Fertig" $checkedFertig/> Fertig
                <input type="radio" name="status[$id]" value="Unterwegs" $checkedUnterwegs/> Unterwegs
                Bestellung von $customerName
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
            $page = new Fahrer();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/html; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

Fahrer::main();
?>

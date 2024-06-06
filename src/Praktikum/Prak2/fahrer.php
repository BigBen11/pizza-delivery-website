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
                $query = "UPDATE `ordered_article` SET `status` = ? WHERE `ordering_id` = ?";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('si', $status, $orderId);
                $stmt->execute();
                $stmt->close();
            }
        }
    }

    protected function getViewData():array
    {
        $query = "SELECT `ordered_article`.`ordering_id`, `ordering`.`address`, GROUP_CONCAT(`article`.`name` SEPARATOR ', ') AS pizza_types
                  FROM `ordered_article` 
                  JOIN `article` ON `ordered_article`.`article_id` = `article`.`article_id` 
                  JOIN `ordering` ON `ordered_article`.`ordering_id` = `ordering`.`ordering_id`
                  WHERE `ordered_article`.`status` = 3
                  GROUP BY `ordered_article`.`ordering_id`, `ordering`.`address`";
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

    $this->generatePageHeader('Fahrer','', true); 

    echo <<<HTML
    <h1> <b>Fahrer (auslieferbare Bestellungen)</b> </h1>
    <hr>
   
    <form method="post" action="fahrer.php">
HTML;

    foreach ($data as $order) {
        $id = htmlspecialchars($order['ordering_id']);
        $address = htmlspecialchars($order['address']);
        $pizzaTypes = htmlspecialchars($order['pizza_types']);
        $status = array_key_exists('status', $order) ? htmlspecialchars($order['status']) : '';
        
        $checkedFertig = $status == '3' ? 'checked' : '';
        $checkedUnterwegs = $status == '4' ? 'checked' : '';

        echo <<<HTML
        <label>
            <input type="radio" name="status[$id]" value="5" $checkedFertig/> Geliefert
            <input type="radio" name="status[$id]" value="3" $checkedFertig/> Fertig
            <input type="radio" name="status[$id]" value="4" $checkedUnterwegs/> Unterwegs
            Bestellung von $address: $pizzaTypes
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

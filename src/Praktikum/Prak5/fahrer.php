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

    protected function processReceivedData(): void
    {
        parent::processReceivedData();

        if (isset($_POST['status'])) {
            foreach ($_POST['status'] as $orderId => $status) {
                $query = "UPDATE `ordered_article` SET `status` = ? WHERE `ordering_id` = ?";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('ii', $status, $orderId);
                $stmt->execute();
                $stmt->close();
            }
            header('Location: fahrer.php');
            die;
        }
    }

    protected function getViewData(): array
    {
        $query = "SELECT `ordered_article`.`ordering_id`, `ordered_article`.`status`, `ordering`.`address` AS address, 
                     GROUP_CONCAT(`article`.`name` SEPARATOR ', ') AS pizza_types, SUM(`article`.`price`) AS total_price
                  FROM `ordered_article`
                  JOIN `article` ON `ordered_article`.`article_id` = `article`.`article_id`
                  JOIN `ordering` ON `ordered_article`.`ordering_id` = `ordering`.`ordering_id`
                  WHERE `ordered_article`.`ordering_id` NOT IN (
                  SELECT `ordered_article`.`ordering_id`
                  FROM `ordered_article`
                  WHERE `ordered_article`.`status` != 3 AND `ordered_article`.`status` != 4
              )
              GROUP BY `ordered_article`.`ordering_id`, `ordering`.`address`, `ordered_article`.`status`";
        $result = $this->db->query($query);
        $orders = [];

        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        $result->free();

        return $orders;
    }

    protected function generateView(): void
    {
        $data = $this->getViewData();

        $this->generatePageHeader('Fahrer', '', true);

        echo <<<HTML
        <h1><b>Fahrer (auslieferbare Bestellungen)</b></h1>
        <hr>
        <form id="fahrer-form" method="post" action="fahrer.php">
HTML;

        if (empty($data)) {
            echo "<p>Es gibt derzeit keine Pizzen zu bearbeiten. Machen Sie eine Pause! 😊</p>";
        } else {
            foreach ($data as $order) {
                $id = htmlspecialchars($order['ordering_id']);
                $address = htmlspecialchars($order['address']);
                $pizzaTypes = htmlspecialchars($order['pizza_types']);
                $totalPrice = number_format((float)$order['total_price'], 2);
                $status = $order['status'];

                $checkedFertig = $status == '3' ? 'checked' : '';
                $checkedUnterwegs = $status == '4' ? 'checked' : '';
                $checkedGeliefert = $status == '5' ? 'checked' : '';

                echo <<<HTML
                <div>
                    <p>Bestellung von $address: $pizzaTypes, $totalPrice EUR</p>
                    <label>
                        <input type="radio" name="status[$id]" value="3" $checkedFertig onclick="document.getElementById('fahrer-form').submit();"/> Fertig
                    </label>
                    <label>
                        <input type="radio" name="status[$id]" value="4" $checkedUnterwegs onclick="document.getElementById('fahrer-form').submit();"/> Unterwegs
                    </label>
                    <label>
                        <input type="radio" name="status[$id]" value="5" $checkedGeliefert onclick="document.getElementById('fahrer-form').submit();"/> Geliefert
                    </label>
                </div>
HTML;
            }
        }

        echo <<<HTML
        </form>
HTML;

        $this->generatePageFooter();
    }

    public static function main(): void
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

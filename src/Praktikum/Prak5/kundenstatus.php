<?php declare(strict_types=1);
require_once './Page.php';

session_cache_limiter('nocache'); // VOR session_start()!
session_cache_expire(0);

class KundenStatus extends Page
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
        header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
        header("Expires: Sat, 01 Jul 2000 06:00:00 GMT"); // Datum in der Vergangenheit
        header("Cache-Control: post-check=0, pre-check=0", false); // für IE
        header("Pragma: no-cache");
    }

    protected function getViewData(): array
    {
        // Überprüfen, ob eine Bestellung in der Session existiert
        if (!isset($_SESSION['orderingId'])) {
            return [];
        }

        $orderingId = $_SESSION['orderingId'];

        // Datenbankabfrage, um die Statusinformationen der bestellten Pizzen zu erhalten
        $query = "SELECT `ordering`.`ordering_id`, `article`.`name`, `ordered_article`.`status`, ordering.address
                  FROM `ordering` 
                  JOIN `ordered_article` ON `ordering`.`ordering_id` = `ordered_article`.`ordering_id` 
                  JOIN `article` ON `ordered_article`.`article_id` = `article`.`article_id` 
                  WHERE `ordering`.`ordering_id` = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $orderingId);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
        $stmt->close();
        return $data;
    }

    protected function generateView(): void
    {
        // Setzen des Headers auf JSON
        header("Content-Type: application/json; charset=UTF-8");
        // Abrufen der Daten
        $data = $this->getViewData();
        // Konvertieren der Daten in JSON und Ausgeben
        $serializedData =  json_encode($data);
        echo $serializedData;
    }

    public static function main(): void
    {
        try {
            session_start();
            $page = new KundenStatus();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/html; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

KundenStatus::main();
?>

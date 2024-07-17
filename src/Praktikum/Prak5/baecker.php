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

    protected function processReceivedData(): void
    {
        parent::processReceivedData();

        if (isset($_POST['status'])) {
            foreach ($_POST['status'] as $orderedArticleId => $status) {
                $query = "UPDATE `ordered_article` SET `status` = ? WHERE `ordered_article_id` = ?";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('ii', $status, $orderedArticleId);
                $stmt->execute();
                $stmt->close();
            }
            header('Location: baecker.php');
            die;
        }
    }

    protected function getViewData(): array
    {
        $query = "SELECT `ordered_article`.`ordered_article_id`, `article`.`name`, `ordered_article`.`status` 
                  FROM `ordered_article` 
                  JOIN `article` ON `ordered_article`.`article_id` = `article`.`article_id`
                  WHERE `ordered_article`.`status` = 1 OR `ordered_article`.`status` = 2 OR `ordered_article`.`status` = 3";

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
        $data = $this->getViewData();

        $this->generatePageHeader('Bäcker', '', true);  // Pass true to enable auto-refresh

        echo <<<HTML
        <h1><b>Pizzabäcker (bestellte Pizzen)</b></h1>
        <hr>
        <form id='baecker-form' method="post" action="baecker.php">
HTML;

        if (empty($data)) {
            echo "<p>Es gibt derzeit keine Pizzen zu bearbeiten. Machen Sie eine Pause! 😊</p>";
        } else {
            foreach ($data as $pizza) {
                $id = htmlspecialchars($pizza['ordered_article_id']);
                $name = htmlspecialchars($pizza['name']);
                $status = $pizza['status'];

                $checkedBestellt = $status == 1 ? 'checked' : '';
                $checkedImOfen = $status == 2 ? 'checked' : '';
                $checkedFertig = $status == 3 ? 'checked' : '';

                echo <<<HTML
                <div>
                    <span>$name</span><br>
                    <label>
                        <input type="radio" name="status[$id]" value="1" onclick="document.forms['baecker-form'].submit();" $checkedBestellt> Bestellt
                    </label>
                    <label>
                        <input type="radio" name="status[$id]" value="2" onclick="document.forms['baecker-form'].submit();" $checkedImOfen> Im Ofen
                    </label>
                    <label>
                        <input type="radio" name="status[$id]" value="3" onclick="document.forms['baecker-form'].submit();" $checkedFertig> Fertig
                    </label>
                </div>
                <br>
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

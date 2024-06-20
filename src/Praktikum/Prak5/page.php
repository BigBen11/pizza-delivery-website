<?php declare(strict_types=1);

abstract class Page
{
    protected MySQLi $db;

    protected function __construct()
    {
        error_reporting(E_ALL);

        $host = "localhost";
        if (gethostbyname('mariadb') != "mariadb") { 
            $host = "mariadb";
        }

        $this->db = new MySQLi($host, "public", "public", "pizzaservice");

        if ($this->db->connect_errno) {
            throw new Exception("Connect failed: " . $this->db->connect_errno);
        }

        if (!$this->db->set_charset("utf8")) {
            throw new Exception($this->db->error);
        }
    }

    public function __destruct()
    {
        $this->db->close();
    }

    protected function generatePageHeader(string $title = "", string $jsFile = "", bool $autoreload = false):void
    {
        $title = htmlspecialchars($title);
        $refresh = $autoreload ? '<meta http-equiv="refresh" content="10">' : ''; // Seite alle 10 Sekunden aktualisieren, wenn $autoreload wahr ist

        if(!empty($jsFile)){
            $js_tag = '<script src="' . $jsFile . '" defer> </script>';
        }
        else {
            $js_tag = "";
        }

        echo <<<EOT
        <!DOCTYPE html>
        <html lang="de">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>$title</title>
            <link rel="stylesheet" type="text/css" href="styles.css">
            $js_tag
        </head>
        <body>
            <header>
                <h1>Willkommen beim Pizzaservice!</h1>
                <nav>
                    <ul>
                        <li><a href="fahrer.php">Fahrer</a></li>
                        <li><a href="baecker.php">Bäcker</a></li>
                        <li><a href="bestellung.php">Bestellungen</a></li>
                        <li><a href="kunde.php">Kunde</a></li>
                    </ul>
                </nav>
            $refresh   
            </header>
        EOT;
    }

    protected function generatePageFooter():void
    {
        echo <<<EOT
        </body>
        </html>
        EOT;
    }

    protected function processReceivedData():void
    {
        // To be overridden in derived classes
    }
}
?>

<?php declare(strict_types=1);

abstract class Page
{
    protected MySQLi $_database;

    protected function __construct()
    {
        error_reporting(E_ALL);

        $host = "localhost";
        /********************************************/
        // This code switches from the the local installation (XAMPP) to the docker installation 
        if (gethostbyname('mariadb') != "mariadb") { 
            $host = "mariadb";
        }
        /********************************************/

        $this->_database = new MySQLi($host, "public", "public", "pizzaservice");

        if ($this->_database->connect_errno) {
            throw new Exception("Connect failed: " . $this->_database->connect_errno);
        }

        // set charset to UTF8
        if (!$this->_database->set_charset("utf8")) {
            throw new Exception($this->_database->error);
        }
    }

    public function __destruct()
    {
        $this->_database->close();
    }

    protected function generatePageHeader(string $title = "", string $jsFile = "", bool $autoreload = false):void
    {
        $title = htmlspecialchars($title);
        header("Content-type: text/html; charset=UTF-8");

        // TO DO: handle all parameters

            echo <<<EOT
            <!DOCTYPE html>
            <html lang="de">
             <head>
                <meta charset="UTF-8">
                <title>$title</title>
            </head>
            <body>
                <header>
                    <h1>Willkommen beim Pizzaservice!</h1>
                    <nav>
                        <ul>
                            <li><a href="fahrer.php">Fahrer</a></li>
                            <li><a href="bestellungen.php">Bestellungen</a></li>
                            <li><a href="kunde.php">Kunde</a></li>
                        </ul>
                    </nav>
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

    }
}
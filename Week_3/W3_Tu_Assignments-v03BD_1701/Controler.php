<?php

require_once "Database.php";
require_once "Table.php";
require_once "DML.php";

class Controler
{
    private $currentDB = "Not Specified";
    private $currentTBL = "Not Specified";
    private $DML_transaction;

    public function __construct()
    {
        echo "HELLO AND WELCOME TO MOUSAWI DATABASE SYSTEM ¯\_(ツ)_/¯ " . PHP_EOL;
        echo "Please write your queries below: (Type \"quit\" to exit)" . PHP_EOL;
        echo ">> ";

        while ($query = fgets(STDIN)) {

            $query = str_replace(PHP_EOL, "", $query);

            //check the structure of each query
            if (preg_match("/^(quit|q|QUIT|Quit)$/", $query)) {
                echo "Thank You for using MousawiDB" . PHP_EOL;
                break;

            } else if (
                preg_match("/^(man|MAN|Man|manual|Manual|MANUAL)$/",
                    $query)
            ) {
                $man_file = file_get_contents('man.txt');
                echo $man_file . PHP_EOL;
                echo ">> ";
                continue;
            } else if (
                preg_match(
                    "/^CREATE\s*,\s*DATABASE\s*,\s*\"([^\"]+)\"$/",
                    $query,
                    $db_name
                )
            ) {
                $DDL_action = new Database("CREATE", $db_name[1]);
                $this->setDB($db_name[1]);
            } else if (
                preg_match(
                    "/^DELETE\s*,\s*DATABASE\s*,\s*\"([^\"]+)\"$/",
                    $query,
                    $db_name
                )
            ) {
                $DDL_action = new Database("DELETE", $db_name[1]);
                $this->setDB("Not Specified");
            } else if (
                preg_match(
                    "/^CREATE\s*,\s*TABLE\s*,\s*\"([^\"]+)\"\s*," .
                    "COLUMNS(,\s*\"(\w*\s*)*\")+$/",
                    $query,
                    $config
                )
            ) {
                if ($this->getDB() == "Not Specified") {
                    echo "Please Specify the Database in which you want" .
                        " to add the table to" . PHP_EOL;
                    echo ">> ";
                    continue;
                }

                $columns = "";
                $queryItems = explode(",", $query);

                for ($i = 4; $i < sizeof($queryItems); $i++) {
                    if ($i == sizeof($queryItems) - 1) {
                        $columns .= substr($queryItems[$i], 1, -1);
                    } else {
                        $columns .= substr($queryItems[$i], 1, -1) . ",";
                    }
                }

                $this->setTBL($config[1]);
                $DDL_action = new Table(
                    "CREATE",
                    $this->getDB(),
                    $this->getTBL(),
                    $columns
                );

            } else if (
                preg_match("/^ADD(,\"([^\"]+)\"\s*)+$/", $query)
            ) {

                if (!$this->openTransaction()) {
                    continue;
                }

                $columns = "";
                $queryItems = explode(",", $query);

                if ((sizeof($queryItems) - 1) != $this->getAttributesNumber()) {
                    echo "Please Specify the right number of attributes.."
                        . PHP_EOL;
                    echo ">> ";
                    continue;
                }

                for ($i = 1; $i < sizeof($queryItems); $i++) {
                    if ($i == sizeof($queryItems) - 1) {
                        $columns .= substr($queryItems[$i], 1, -1);
                    } else {
                        $columns .= substr($queryItems[$i], 1, -1) . ",";
                    }
                }
                $this->get_DML_transaction()->doAction("ADD", $columns);

            } else if (
                preg_match(
                    "/^GET\s*(,\s*\"(\w*\s*)*\"\s*){0,2}$/",
                    $query
                )
            ) {
                if (!$this->openTransaction()) {
                    continue;
                }

                if (
                    preg_match(
                        "/^GET\s*,\s*\"([^\"]+)\"\s*$/",
                        $query,
                        $config)
                ) {
                    //echo "get records of specific id";
                    if (is_numeric($config[1])) {
                        //search for id
                        if (!$id = $this->getTableId()) {
                            continue;
                        }
                        $this->get_DML_transaction()->doAction("GET", $id, $config[1]);
                    } else {
                        //get all of that column
                        $this->get_DML_transaction()->doAction("GET", $config[1], "");
                    }
                } else if (preg_match("/^GET\s*$/", $query)) {
                    //echo "gets all records";
                    $this->get_DML_transaction()->doAction("GET", "", "");

                } else if (
                    preg_match(
                        "/^GET\s*,\s*\"([^\"]+)\"\s*,\s*\"([^\"]+)\"\s*$/",
                        $query,
                        $config
                    )
                ) {
                    $this->get_DML_transaction()->doAction("GET", $config[1], $config[2]);
                }

            } else if (
                preg_match(
                    "/^DELETE\s*,\s*ROW,\"([^\"]+)\"$/",
                    $query,
                    $config
                )
            ) {
                if (!$this->openTransaction()) {
                    continue;
                }
                $this->get_DML_transaction()->doAction("DELETE", $config[1]);
            } else if (preg_match("/^COMMIT$/", $query)) {
                if (!$this->openTransaction()) {
                    continue;
                }
                $this->get_DML_transaction()->commitToTable();
            } else if (preg_match("/^ROLLBACK$/", $query)) {
                if (!$this->openTransaction()) {
                    continue;
                }
                $this->get_DML_transaction()->rollBackToTable();
            } else if (
                preg_match(
                    "/^SPECIFY\s*,\s*DATABASE\s*,\s*\"([^\"]+)\"\s*$/",
                    $query,
                    $config
                )
            ) {
                if (!is_dir("Databases" . DIRECTORY_SEPARATOR . $config[1])) {
                    echo "Database does not exist! Please specify a created" .
                        " database or create one!" . PHP_EOL;
                    echo ">> ";
                    continue;
                }
                $this->setDB($config[1]);
                if ($this->get_DML_transaction() != null) {
                    $this->get_DML_transaction()->commitToTable();
                    $this->start_DML_transaction(null);
                }
                $this->setTBL("Not Specified");
                echo "The choosen database is specified successfully.." . PHP_EOL;
            } else if (
                preg_match(
                    "/^SPECIFY\s*,\s*TABLE\s*,\s*\"([^\"]+)\"\s*$/",
                    $query,
                    $config
                )
            ) {
                if ($this->getDB() == "Not Specified") {
                    echo "Please Specify a Database first .. " . PHP_EOL;
                    echo ">> ";
                    continue;
                }
                if (
                    !is_file(
                        "Databases" . DIRECTORY_SEPARATOR . $this->getDB() .
                        DIRECTORY_SEPARATOR . $config[1]
                    )
                ) {
                    echo "Table does not exist! Please specify a created" .
                        " table or create one!" . PHP_EOL;
                    echo ">> ";
                    continue;
                }
                $this->setTBL($config[1]);
                if ($this->get_DML_transaction() != null) {
                    $this->get_DML_transaction()->commitToTable();
                    $this->start_DML_transaction(null);
                }
                echo "The choosen table is specified successfully.." . PHP_EOL;
            } else {
                echo "OPPS.. TYPO BRO..(To check manual please type \"man\")" . PHP_EOL;
            }
            echo ">> ";
        }

    }

    public function getAttributesNumber()
    {
        $db_name = $this->getDB();
        $tbl_name = $this->getTBL();

        $tbl_path = "Databases" . DIRECTORY_SEPARATOR . $db_name .
            DIRECTORY_SEPARATOR . $tbl_name;

        if (file_exists($tbl_path)) {
            $fileOpened = fopen($tbl_path, "r");
            if ($fileOpened) {
                if ($firstLine = fgets($fileOpened)) {
                    $attributes = explode(",", $firstLine);
                    return sizeof($attributes);
                }
            }
        } else {
            echo "ERROR!! Somthing went wrong on the table .." . PHP_EOL;
            echo ">> ";
        }
        return false;
    }

    public function getTableId()
    {
        $db_name = $this->getDB();
        $tbl_name = $this->getTBL();

        $tbl_path = "Databases" . DIRECTORY_SEPARATOR . $db_name .
            DIRECTORY_SEPARATOR . $tbl_name;

        if (file_exists($tbl_path)) {
            $fileOpened = fopen($tbl_path, "r");
            if ($fileOpened) {
                if ($firstLine = fgets($fileOpened)) {
                    $attributes = explode(",", $firstLine);
                    return $attributes[0];
                }
            }
        } else {
            echo "ERROR!! Somthing went wrong on the table .." . PHP_EOL;
            echo ">> ";
        }
        return false;
    }

    public function setDB($newDB_name)
    {
        $this->currentDB = $newDB_name;
    }

    public function setTBL($newTBL_name)
    {
        $this->currentTBL = $newTBL_name;
    }

    public function getDB()
    {
        return $this->currentDB;
    }

    public function getTBL()
    {
        return $this->currentTBL;
    }

    public function openTransaction()
    {
        if (
            $this->getDB() == "Not Specified" ||
            $this->getTBL() == "Not Specified"
        ) {
            echo "ERROR!! Database or Table in which you want to add" .
                " the record is not specified.." . PHP_EOL;
            echo ">> ";
            return false;
        }

        if ($this->get_DML_transaction() == null) {
            $DML_transaction = new DML($this->getDB(), $this->getTBL());
            $this->start_DML_transaction($DML_transaction);
        }
        return true;
    }

    public function start_DML_transaction($dml_transaction)
    {
        $this->DML_transaction = $dml_transaction;
    }

    public function get_DML_transaction()
    {
        return $this->DML_transaction;
    }
}

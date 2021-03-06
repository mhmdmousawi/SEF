<?php

class Database
{
    private $DB_Name;
    public function __construct($action, $DB_Name)
    {
        $this->setDB_Name($DB_Name);

        if ($action == "CREATE") {
            $this->createDB($this->getDB_Name());
        } else if ($action == "DELETE") {
            $this->deleteDB($this->getDB_Name());
        } else {
            echo "OPPS.. Typo.." . PHP_EOL;
        }

    }

    public function createDB($db_name)
    {
        if (!file_exists("Databases")) {
            mkdir("Databases");
        }

        $db_path = "Databases" . DIRECTORY_SEPARATOR . $db_name;

        if (!file_exists($db_path)) {
            mkdir($db_path);
            echo "\"" . $db_name . "\" CREATED" . PHP_EOL;

        } else {
            echo "Database \"" . $db_name .
                "\" is already created" . PHP_EOL;
        }
    }

    public function deleteDB($db_name)
    {
        $DB_Path = "Databases" . DIRECTORY_SEPARATOR . $db_name;
        if (file_exists($DB_Path)) {
            rmdir($DB_Path);
            echo "\"" . $db_name . "\" DELETED" . PHP_EOL;
        } else {
            echo "Database \"" . $db_name .
                "\" does not exist" . PHP_EOL;
        }
    }

    public function setDB_Name($db_name)
    {
        $this->DB_Name = $db_name;
    }

    public function getDB_Name()
    {
        return $this->DB_Name;
    }
}

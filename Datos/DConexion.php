<?php
namespace Datos;

class Conexion
{

    private $connection;
    private $statement;

    private const HOST = "localhost";
    private const DATABASE = "arqui";
    private const USER = "root";
    private const PASS = "root";

    public function __construct()
    {
        $this->connection = null;
    }

    public function connect()
    {
        $dsn = "mysql:host=" . self::HOST . ";dbname=" . self::DATABASE;
        try {
            $this->connection = new \PDO($dsn, self::USER, self::PASS);
           
            return true;
        } catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return false;
        }
    }
    function Consulta($sql)
    {
        if (!$this->connection) {
            $this->connect(); // Si la conexión no está establecida, intenta conectarse
        }
    
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement;
    }
    
    

    public function close()
    {
        if ($this->connection != null) {
            echo "Disconnected\n";
            if ($this->statement != null) {
                $this->statement->closeCursor();
            }
            $this->connection = null;
        }
        return true;
    }

    public function select($query)
    {
        $this->statement = $this->connection->prepare($query);
        $this->statement->execute();
        $result = $this->statement->fetchAll();
        echo "Select send\n";
        return $result;
    }

    public function insert($query)
    {
        $this->statement = $this->connection->prepare($query);
        $this->statement->execute();
        $lastInsertedId = $this->connection->lastInsertId();
        echo "Insert send\n";
        return $lastInsertedId;
    }

    public function update($query)
    {
        $this->statement = $this->connection->prepare($query);
        $this->statement->execute();
        echo "Update send\n";
        return true;
    }

    public function delete($query)
    {
        $this->statement = $this->connection->prepare($query);
        $this->statement->execute();
        echo "Delete send\n";
        return true;
    }
}

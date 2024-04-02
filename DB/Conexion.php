<?php

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
            // Establecer el modo de error para lanzar excepciones en lugar de avisos
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $this->connection;
        } catch (\PDOException $e) {
            throw new \PDOException("Connection failed: " . $e->getMessage());
        }
    }
    
    
    /* consulta la conexión y hace respectivas consultas a la BD */
    function consultarBD($sql, $params = [])
    {
        if (!$this->connection) {
            $this->connect(); // Si la conexión no está establecida, intenta conectarse
        }

        $statement = $this->connection->prepare($sql);

        if (empty($params)) {
            $statement->execute();
        } else {
            $statement->execute($params);
        }

        return $statement;
    }




    public function close()
    {
        if ($this->connection != null) {
            // echo "Disconnected\n";
            if ($this->statement != null) {
                $this->statement->closeCursor();
            }
            $this->connection = null;
        }
        return true;
    }
}

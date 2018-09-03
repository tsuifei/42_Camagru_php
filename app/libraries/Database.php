<?php
/*
 * PDO Database Class * PDO數據庫類
 * Connect to database * 連接到數據庫
 * Create prepared statements * 創建準備好的語句
 * Bind Values * 綁定值
 * Return rows and results * 返回行和結果
 */
class Database 
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
    
    private $dbh;
    private $stmt;
    private $error;

    public function __construct() //負責一用到Database這個類，就先測試連線。
    {
        // Set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';charset=utf8';
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        // Create PDO instance 創建PDO實例
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
            // echo 'connecton ok';
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }

    }

    // prepare statement with query 準備查詢用語句
    public function query($sql)
    {
        $this->stmt = $this->dbh->prepare($sql);
    }

    // Bind Values 綁定值
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) // 先確定數據的型態type
        {
            switch(true)
            {
                case is_int($value):
                    $type= PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type= PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type= PDO::PARAM_NULL;
                    break;
                default:
                    $type= PDO::PARAM_STR;
            }
        }
        //綁定
        $this->stmt->bindValue($param, $value, $type);
    }

    // Execute the prepared statement 執行準備好的語句
    public function execute()
    {
        return $this->stmt->execute();
    }

    // Get result set as array of objects 獲取結果集 作為obj數組
    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Get single record as object 獲取單個記錄作為對象
    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    // Get row count 獲得行數
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
}
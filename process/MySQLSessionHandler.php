<?php
require_once 'db_credentials.php';

class MySQLSessionHandler implements SessionHandlerInterface
{
    private $connection;
 
    public function __construct()
    {
        $this->connection = new mysqli(HOST_NAME,USERNAME,PASSWORD,DATABASENAME);
    }
 
    public function open($savePath, $sessionName)
    {
        if ($this->connection) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
 
    public function read($sessionId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT session_data FROM sessions WHERE session_id = ?");
            $stmt->bind_param("s", $sessionId);
            $stmt->execute();
            $stmt->bind_result($sessionData);
            $stmt->fetch();
            $stmt->close();
 
            return $sessionData ? $sessionData : '';
        } catch (Exception $e) {
            return '';
        }
    }
 
    public function write($sessionId, $sessionData)
    {
        try {
            $stmt = $this->connection->prepare("REPLACE INTO sessions(`session_id`, `created`, `session_data`) VALUES(?, ?, ?)");
            // $stmt->bind_param("sis", $sessionId, $time=time(), $sessionData);
            $time = time();
            $stmt->bind_param("sis", $sessionId, $time, $sessionData);
            $stmt->execute();
            $stmt->close();
 
            return TRUE;
        } catch (Exception $e) {
            return FALSE;
        }
    }
 
    public function destroy($sessionId)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM sessions WHERE session_id = ?");
            $stmt->bind_param("s", $sessionId);
            $stmt->execute();
            $stmt->close();
 
            return TRUE;
        } catch (Exception $e) {
            return FALSE;
        }
    }
 
    public function gc($maxlifetime)
    {
        $past = time() - $maxlifetime;
 
        try {
            $stmt = $this->connection->prepare("DELETE FROM sessions WHERE `created` < ?");
            $stmt->bind_param("i", $past);
            $stmt->execute();
            $stmt->close();
 
            return TRUE;
        } catch (Exception $e) {
            return FALSE;
        }
    }
 
    public function close()
    {
        return TRUE;
    }

    public function session_start() 
    {
      session_set_save_handler($this, true);
      session_start();
    }
}

?>
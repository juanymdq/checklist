<?php 
/**
 * This file contains the Backup_Database class wich performs
 * a partial or complete backup of any given MySQL database
 * @author Daniel López Azaña <http://www.azanweb.com-->
 * @version 1.0
 */

// Report all errors
error_reporting(E_ALL);

/**
 * Define database parameters here
 */
define("DB_USER", 'root');
define("DB_PASSWORD", '');
define("DB_NAME", 'check');
define("DB_HOST", 'localhost');
define("OUTPUT_DIR", 'cache');
define("TABLES", '*');

/**
 * Instantiate Backup_Database and perform backup
 */
$backupDatabase = new Backup_Database(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$status = $backupDatabase->backupTables(TABLES, OUTPUT_DIR) ? 'OK' : 'KO';
echo "

Backup result: ".$status;

/**
 * The Backup_Database class
 */
class Backup_Database {
    /**
     * Host where database is located
     */
    var $host = 'localhost';

    /**
     * Username used to connect to database
     */
    var $username = 'root';

    /**
     * Password used to connect to database
     */
    var $passwd = '';

    /**
     * Database to backup
     */
    var $dbName = 'check';

    /**
     * Database charset
     */
    var $charset = '';

    /**
     * Constructor initializes database
     */
    function Backup_Database($host, $username, $passwd, $dbName, $charset = 'utf8')
    {
        $this->host     = $host;
        $this->username = $username;
        $this->passwd   = $passwd;
        $this->dbName   = $dbName;
        $this->charset  = $charset;

        $this->initializeDatabase();
    }

    protected function initializeDatabase()
    {
        $conn = mysql_connect($this->host, $this->username, $this->passwd);
        mysql_select_db($this->dbName, $conn);
        if (! mysql_set_charset ($this->charset, $conn))
        {
            mysql_query('SET NAMES '.$this->charset);
        }
    }

    /**
     * Backup the whole database or just some tables
     * Use '*' for whole database or 'table1 table2 table3...'
     * @param string $tables
     */
    public function backupTables($tables = '*', $outputDir = 'c:/')
    {
        try
        {
            /**
            * Tables to export
            */
            if($tables == '*')
            {
                $tables = array();
                $result = mysql_query('SHOW TABLES');
                while($row = mysql_fetch_row($result))
                {
                    $tables[] = $row[0];
                }
            }
            else
            {
                $tables = is_array($tables) ? $tables : explode(',',$tables);
            }

            $sql = 'CREATE DATABASE IF NOT EXISTS '.$this->dbName.";\n\n";
            $sql .= 'USE '.$this->dbName.";\n\n";

            /**
            * Iterate tables
            */
            foreach($tables as $table)
            {
                echo "Backing up ".$table." table...";

                $result = mysql_query('SELECT * FROM '.$table);
                $numFields = mysql_num_fields($result);

                $sql .= 'DROP TABLE IF EXISTS '.$table.';';
                $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
                $sql.= "\n\n".$row2[1].";\n\n";

                for ($i = 0; $i < $numFields; $i++) 
                {
                    while($row = mysql_fetch_row($result))
                    {
                        $sql .= 'INSERT INTO '.$table.' VALUES(';
                        for($j=0; $j<$numFields; $j++) 
                        {
                            $row[$j] = addslashes($row[$j]);
                            $row[$j] = preg_replace("#\n#","#\\n#",$row[$j]);
                            if (isset($row[$j]))
                            {
                                $sql .= '"'.$row[$j].'"' ;
                            }
                            else
                            {
                                $sql.= '""';
                            }

                            if ($j < ($numFields-1))
                            {
                                $sql .= ',';
                            }
                        }

                        $sql.= ");\n";
                    }
                }

                $sql.="\n\n\n";

                echo " OK" . "
";
            }
        }
        catch (Exception $e)
        {
            var_dump($e->getMessage());
            return false;
        }

        return $this->saveFile($sql, $outputDir);
    }

    /**
     * Save SQL to file
     * @param string $sql
     */
    protected function saveFile(&$sql, $outputDir = 'c:/')
    {
        if (!$sql) return false;

        try
        {
            $narchivo = $_POST['archivo'];
            $ruta = $_POST['ruta'];
            $handle = fopen($ruta.'/'.$narchivo.'-'.date("Ymd").'.sql','w');
            //$handle = fopen('C:/xampp/htdocs/checklist/BackupBD/backup -'.date("Ymd-His", time()).'.sql','w');
            //$handle = fopen($outputDir.'/'.$this->dbName.'-'.date("Ymd-His", time()).'.sql','w');
            fwrite($handle, $sql);
            fclose($handle);
            header("location: principal.php?id=backup_principal&accion=1");
        }
        catch (Exception $e)
        {
            var_dump($e->getMessage());
            
            return false;
        }

        return true;
    }
}
?>
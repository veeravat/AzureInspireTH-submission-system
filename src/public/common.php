<?PHP

require '../class/pdo.php';

$config = require '../conf/constant.php';

$db = new Db($config->setting->db->host, 
                $config->setting->db->database,
                $config->setting->db->username, 
                $config->setting->db->password);

                ?>
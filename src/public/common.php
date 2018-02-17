<?PHP

require '../class/pdo.php';

$config = require '../conf/constant.php';

$DB = new Db($config->setting->db->host, 
                $config->setting->db->database,
                $config->setting->db->username, 
                $config->setting->db->password);



// $results = $DB->single("SHOW TABLES LIKE 'geekathon'");
// print_r($results);
// if ($results == true) {
//     return;
// } else {
//     // create table
//     $sql = "CREATE TABLE `geekathon` (
//         `UID`  int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT ,
//         `firstname`  varchar(255) NULL ,
//         `lastname`  varchar(255) NULL ,
//         `username`  varchar(255) NULL ,
//         `password`  varchar(255) NULL ,
//         PRIMARY KEY (`UID`)
//         )
//     ;";
//     $conn->query($sql);
// }
                ?>
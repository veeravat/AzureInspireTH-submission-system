<?php
foreach ($_SERVER as $key => $value) {
    if (strpos($key, "MYSQLCONNSTR_") !== 0) {
        continue;
    }

    $servername = preg_replace("/^.*Data Source=(.+?);.*$/", "\\1", $value);
    $dbname = preg_replace("/^.*Database=(.+?);.*$/", "\\1", $value);
    $username = preg_replace("/^.*User Id=(.+?);.*$/", "\\1", $value);
    $password = preg_replace("/^.*Password=(.+?)$/", "\\1", $value);
}

if(isset($servername)){
return $clasa = json_decode(json_encode([
    'setting' => [
        'db' => [
            'driver'    => 'mysql',
            'host'      => $servername,
            'database'  => $dbname,
            'username'  => $username,
            'password'  => $password,
            'charset'   => 'utf8',
            'collation' => 'utf8_general_ci',
            'prefix'    => ''
        ]
    ]
]));
}
else{
return $clasa = json_decode(json_encode([
    'setting' => [
        'db' => [
            'driver'    => 'mysql',
            'host'      => 'mysql-tm.mysql.database.azure.comx',
            'database'  => 'localdb',
            'username'  => 'tuymove@mysql-tm',
            'password'  => '@zuredata1',
            'charset'   => 'utf8',
            'collation' => 'utf8_general_ci',
            'prefix'    => ''
        ]
    ]
]));
}
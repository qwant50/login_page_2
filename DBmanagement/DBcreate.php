<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/datarec/DBmanagement/config.php';


// delete all tables;
$sql = "DROP TABLE users;";
$res = $mysqli->query($sql);
$sql = "DROP TABLE invites;";
$res = $mysqli->query($sql);

//  Creating 'countries' table;
$sql = "
 CREATE TABLE IF NOT EXISTS countries (
  id_country int(10) unsigned NOT NULL AUTO_INCREMENT,
  country_name varchar(100) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (id_country),
  UNIQUE country_name (country_name)
) ENGINE=InnoDB
    ";
$res = $mysqli->query($sql);

// Creating 'cities' table;
$sql ="
CREATE TABLE IF NOT EXISTS cities (
  id_city int(10) unsigned NOT NULL AUTO_INCREMENT,
  id_country int(10) unsigned NOT NULL,
  city_name varchar(100) NOT NULL,
  PRIMARY KEY (id_city),
  FOREIGN KEY (id_country) REFERENCES countries (id_country),
  UNIQUE city_name (city_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";
$res = $mysqli->query($sql);

$country_names = array('Cambodia', 'Swaziland', 'Macedonia', 'San Marino', 'Nicaragua', 'Bangladesh', 'Belarus');
foreach ($country_names as $country_name) {

    $sql = "INSERT INTO countries (id_country, country_name) VALUES (NULL, '$country_name');";
    $res = $mysqli->query($sql);
    for ($i = 0; $i<10 ; $i++){
        $city_name =$country_name.'-city'.$i;
        $sql =  "INSERT INTO  cities (id_country , city_name) SELECT id_country, '$city_name'
            FROM countries WHERE country_name =  '$country_name' LIMIT 1;";
        $res = $mysqli->query($sql);
    }
};


//Creating 'invites' table;
$sql ="
CREATE TABLE IF NOT EXISTS invites (
  invite varchar(6) NOT NULL,
  status tinyint(1) NOT NULL,
  date_status_ date,
  PRIMARY KEY (invite)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";
$res = $mysqli->query($sql);

$invites = array('000000','999999','000001','000002','123456','654321','909090');
foreach ($invites as $invite){
    $sql = "INSERT INTO invites (invite, status) VALUES ('$invite', 0);";
    $res = $mysqli->query($sql);
};

$sql = "CREATE TABLE IF NOT EXISTS users (
  id_user int(10) unsigned NOT NULL AUTO_INCREMENT,
  login varchar(200) NOT NULL,
  password varchar(200) NOT NULL,
  phone varchar(200),
  id_city int(10) unsigned,
  invite varchar(6) NOT NULL,
  PRIMARY KEY (id_user),
  FOREIGN KEY (id_city) REFERENCES cities (id_city),
  FOREIGN KEY (invite) REFERENCES invites (invite)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";
$res = $mysqli->query($sql);

if ($mysqli) $mysqli->close();


?>
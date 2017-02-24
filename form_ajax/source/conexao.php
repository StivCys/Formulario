<?php
$host="localhost";
$port=3306;
$socket="";
$username="root";
$password="";
$dbname="teste_estevo";

// Create connection
$con = new mysqli($host, $username, $password);
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
} 

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS " . $dbname;
if ($con->query($sql) === TRUE) {
    //echo "Database created successfully";
} else {
   // echo "Error creating database: " . $con->error;
}



$con = new mysqli($host, $username, $password, $dbname, $port, $socket)
	or die ('Could not connect to the database server' . mysqli_connect_error());

//PERSISTENCIA
if (!$con->query("CREATE TABLE IF NOT EXISTS `cadastro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `razao_social` varchar(45) NOT NULL,
  `cnpj` varchar(18) DEFAULT NULL,
  `insc_m` varchar(15) DEFAULT NULL,
  `cep` varchar(9) DEFAULT NULL,
  `logradouro` varchar(80) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `complemento` varchar(45) DEFAULT NULL,
  `bairro` varchar(80) DEFAULT NULL,
  `cidade` varchar(60) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `telefone` varchar(14) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
")) {
    echo "Table creation failed: (" . $con->errno . ") " . $con->error;
}else{}

//$con->close();

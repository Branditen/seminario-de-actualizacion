<?php
    $dsn = "mysql:host=localhost;dbname=dbcarlos";
    $dbusername = "root";
    $dbpassword = "";
   
try {
    //Creo un objeto del tipo PDO
    $objetoConexionDb = new PDO($dsn,$dbusername,$dbpassword);
    $objetoConexionDb->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (PDOException $error) {
    echo "Fallo de conexión: " . $error->getMessage();
}

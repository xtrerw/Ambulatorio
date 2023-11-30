<?php
function getConexion() {
    $servidor="localhost";
    $user="root";
    $password="";
    $db = "ambulatorio";
    $conexion=mysqli_connect($servidor,$user,$password, $db) or die("error de conexión de servidor");
    return $conexion;
}

function getConexionsinBD() {
    $servidor="localhost";
    $user="root";
    $password="";
    $conexion=mysqli_connect($servidor,$user,$password) or die("error de conexión de servidor");
    return $conexion;
}

?>
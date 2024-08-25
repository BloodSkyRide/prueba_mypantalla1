<?php

require_once('conexion.php'); // importo el archivo de conexion
$user = $_POST["user"]; // obtengo los parametros enviado desde el front

if(isset($user) && isset($_POST["pass"])){ // verifico que esos paremetros tengan algo

    $pass = $_POST["pass"];
    $query = "SELECT * FROM users WHERE nombre = '$user'"; // query de la consulta
    $comprobar = mysqli_query($conn,$query); //verifico la conexion
    $registro = $comprobar->fetch_assoc(); // a esta variable le meto la fila encontrada en la base de datos
    $hash_bd = $registro['password']; // en esta variable guardo la password obtenida de la base de datos, esta esta encriptada
    $res = password_verify($pass,$hash_bd); // verifico que el password ingresado al hashear, sea el mismo del obtenido em BBDD
    $user_bd = $registro['nombre']; // por ultimo obtengo de las BBDD el nombre de usuario
    
        if($res && $user_bd == $user){ // pregunto si la verificacion fue exitosa, la variable res devuelve true o false y comparo si el nombre de usuario ingresado es el mismo de las BBDD

            
            session_start(); // inicio una sesion para variables globales
            $_SESSION["nombre"] = $user; 
            $_SESSION["password"] = $pass;
            $_SESSION["rol"] = $registro["rol"];
            $_SESSION["id_user"] = $registro["id_persona"];


            header('Content-Type: application/json');
            echo json_encode(array("status" => true, "sesion_nombre" => $_SESSION["nombre"] ));
    
    
        }else{

            header('Content-Type: application/json');
            echo json_encode(array("status" => false));

        }


}
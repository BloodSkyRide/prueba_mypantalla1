<?php

require_once('conexion.php');

$query = 'SELECT * FROM users';
$productos = mysqli_query($conn, $query);


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>prueba</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

<body>

<div class="mt-5 d-flex justify-content-center">

  <div class="form-control justify-content-center shadow p-3 mb-5 bg-body container-login">
    <center><h3 style="font-family: Verdana, Geneva, Tahoma, sans-serif">Bienvenidos</h3></center>
    <div class="d-flex justify-content-center">
    <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" class="card-img-top container-img" alt="..." >
    </div>
  
  
    <input class="form-control m-2" type="text" placeholder="Ingresar Usuario" id="user">
    <input class="form-control m-2" type="password" placeholder="Ingresar password" id="pass">


    <div class="d-flex justify-content-center mt-2">
    <button class="btn btn-primary" onclick="ingresar()"><i class="fa-solid fa-user" ></i>&nbsp;Ingresar</button>
    </div>
    

  </div>

</div>


</body>



</html>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<script
  src="https://code.jquery.com/jquery-3.7.1.js"
  integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
  crossorigin="anonymous"></script>
<script>


  function ingresar(){

    
    let user = document.getElementById("user").value;
    let pass = document.getElementById("pass").value;

    $.ajax({
        url: 'comprobar.php',
        type: "POST",
        dataType: "JSON",
        data: {
            user,
            pass
        }
    }).done(function (res) {

      if (res.status) {

        alert("comprobado correctamente");

        console.log("la sesion si existe el nombre es: "+res.sesion_nombre);
        console.log("la sesion si existe el password es: "+res.sesion_password);
         window.location.href = './admin.php';
      }

      else{

        alert("Usuario y/o contraseña incorrecta!");

      }

    })


  }
</script>
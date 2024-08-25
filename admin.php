<?php
session_start();

if (isset($_SESSION['nombre'])  && isset($_SESSION['password']) && isset($_SESSION['rol'])) {
    require_once('conexion.php');
    if ($_SESSION['rol'] == 1) {

        $query = 'SELECT * FROM users WHERE rol = 0';
        $usuarios = mysqli_query($conn, $query);
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Menu Administrador</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
        </head>

        <body>
            <center>
                <h1>Bienvenido <?php echo strtoupper($_SESSION['nombre']) . " eres un administrador!"; ?></h1>
            </center>
            <div class="d-flex justify-content-center mt-5">


                <button type="button" class="btn btn-primary m-2" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-briefcase"></i>&nbsp;Crear Tarea</button>
            </div>
            <center>

                <div id="tabla" style="width: 800px;">
                    <?php

                    $id_user = $_SESSION['id_user'];
                    $query = "SELECT * FROM tareas t JOIN users u ON t.id_persona = u.id_persona";
                    $tareas = mysqli_query($conn, $query);
                    ?>

                    <table class="table table-primary shadow p-3 mb-5 bg-body rounded">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Titulo</th>
                                <th scope="col">Descripcion</th>
                                <th scope="col">fecha</th>
                                <th scope="col">Asignado a</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tareas as $tarea) { ?>
                                <tr>
                                    <th scope="row"><?php echo $tarea["id_tarea"]; ?></th>
                                    <td><?php echo $tarea["nombre_tarea"]; ?></td>
                                    <td><?php echo $tarea["descripcion"]; ?></td>
                                    <td><?php echo $tarea["fecha"]; ?></td>
                                    <td><?php echo $tarea["nombre"]; ?></td>

                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>

            </center>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Asignar tarea al usuario</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="form-control">
                                <label for="selector">Selecciona el usuario:</label>
                                <select class="form-select" aria-label="Default select example" id="selector">
                                    <?php foreach ($usuarios as $usuario) { ?>
                                        <option value="<?php echo $usuario['id_persona']; ?> "><?php echo  $usuario['nombre']; ?> </option>
                                    <?php } ?>
                                </select>
                                <label for="nombre">Asignar nombre de tarea:</label>
                                <input type="text" placeholder="Nombre de la tarea" id="nombre" class="form-control">
                                <label for="nombre">Descripcion tarea:</label>
                                <textarea name="descripcion" id="descripcion" rows="2" class="form-control" placeholder="Descripcion"></textarea>
                                <label for="nombre">Fecha</label>
                                <input type="date" id="fecha" class="form-control">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button onclick="asignarTarea()" id="button" type="button" class="btn btn-primary" data-id="<?php echo $_SESSION['id_user'] ?>">Asignar tarea</button>
                        </div>
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
            function asignarTarea() {

                let id_user = document.getElementById("selector").value;
                let nombre_tarea = document.getElementById("nombre").value;
                let descripcion = document.getElementById("descripcion").value;
                let fecha = document.getElementById("fecha").value;
                let self_id = document.getElementById("button").dataset.id;



                $.ajax({

                    url: 'asignacion.php',
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        id_user,
                        nombre_tarea,
                        descripcion,
                        fecha,
                        self_id
                    }
                }).done(function(res) {

                    if (res.status) {
                        console.log("asignacion existosa!");
                        $("#nombre").val("");
                        $("#descripcion").val("");
                        $("#fecha").val("");
                        $("#exampleModal").modal('hide');

                        let tabla = document.getElementById("tabla");
                        tabla.innerHTML = res.contenido;
                    } else {

                        alert("Hubo algun error al intentar asignar la tarea");
                    }

                })


            }
        </script>

    <?php
    } else {
    ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
            <title>Menu usuario</title>
        </head>

        <body>
            <center>
                <h1>Bienvenido <?php echo strtoupper($_SESSION['nombre']); ?></h1>
            </center>

            <?php

            $id_user = $_SESSION['id_user'];
            $query = "SELECT * FROM tareas t JOIN users u ON t.id_persona_asignadora = u.id_persona";
            $tareas = mysqli_query($conn, $query);




            ?>

            <div class="d-flex justify-content-center">
                <div class="d-flex " style="width: 800px;">

                    <table class="table table-primary shadow p-3 mb-5 bg-body rounded">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Titulo</th>
                                <th scope="col">Descripcion</th>
                                <th scope="col">fecha</th>
                                <th scope="col">Asignado por</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tareas as $tarea) { ?>
                                <tr>
                                    <th scope="row"><?php echo $tarea["id_tarea"]; ?></th>
                                    <td><?php echo $tarea["nombre_tarea"]; ?></td>
                                    <td><?php echo $tarea["descripcion"]; ?></td>
                                    <td><?php echo $tarea["fecha"]; ?></td>
                                    <td><?php echo $tarea["nombre"]; ?></td>

                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
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

<?php
    }
} ?>
<?php

$id_user = $_POST["id_user"];
$nombre_tarea = $_POST["nombre_tarea"];
$descripcion = $_POST["descripcion"];
$fecha = $_POST["fecha"];



if (isset($id_user) && isset($nombre_tarea) && isset($descripcion) && isset($fecha)) {

    require_once('conexion.php');
    $self_id = $_POST["self_id"];
    $insert = "INSERT INTO tareas (id_persona, nombre_tarea, descripcion, fecha, id_persona_asignadora) VALUES ('$id_user', '$nombre_tarea', '$descripcion','$fecha', '$self_id')";


    $insercion_tarea = mysqli_query($conn, $insert);
    
    if ($insercion_tarea) {

        $query = "SELECT * FROM tareas t JOIN users u ON t.id_persona = u.id_persona";
        $tareas = mysqli_query($conn, $query)->fetch_all(MYSQLI_ASSOC);

        if ($tareas) {


            $contenido = "<table class='table table-primary shadow p-3 mb-5 bg-body rounded' style='width: 90%; margin-top: 50px;'>
            <thead>
              <tr>
                <th scope='col'>#</th>
                <th scope='col'>Título</th>
                <th scope='col'>Descripción</th>
                <th scope='col'>Fecha</th>
                <th scope='col'>Asignado a</th>
              </tr>
            </thead>
            <tbody>";

            foreach ($tareas as $tarea) {

                $contenido .= "<tr>
                <th scope='row'>" . $tarea['id_tarea'] . "</th>
                <td>" . $tarea['nombre_tarea'] . "</td>
                <td>" . $tarea['descripcion'] . "</td>
                <td>" . $tarea['fecha'] . "</td>
                <td>" . $tarea['nombre'] . "</td>
              </tr>";

            }

            $contenido .= "</tbody>
          </table>";
            header("content-type: application/json");
            echo json_encode(array("status" => true, "contenido" => $contenido));
        }
    }
} else {

    header("content-type: application/json");
    echo json_encode(array("status" => false));
}

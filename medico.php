<?php
include("tablas/crea_tablas.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Médico</title>
    <link rel="shortcut icon" href="img/logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="css/medico.css">
</head>
<body>
    <!-- header -->
    <header>
        <img src="img/logo.jpg" alt="" srcset="">
        <div>
            <a href="index.php">Inicia Sesión</a>
        </div>
    </header>
    <!-- contenido -->
    <div class="container">
        <!-- formulario de información de médico -->
    <form action="consulta.php" method="post">
        <fieldset>
            <legend>
                Médico
            </legend>
            <!-- información -->
            <label for="">Información de Médico</label>
            <table>
                <thead>
                    <tr>
                        <td>ID de Médico</td>
                        <td>Nombre</td>
                        <td>Apellido</td>
                        <td>Especialidad</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (isset($_POST['login']) && isset($_POST['medico'])) {
                            //conseguir id de médico que inicia sesión
                            $medicoSelect=$_POST['medico'];
                            //conseguir toda información del médico,"DISTINCT" para que no repite aparecer el mismo médico
                            $select="SELECT DISTINCT * FROM medico WHERE id='$medicoSelect'";
                            $resulta=mysqli_query($conexion,$select);
                            while ($informacion= $resulta->fetch_assoc()) {
                                //información de médico que contiene nombre,apellidos y especialidad
                                echo "
                                    <tr>
                                        <td>{$informacion['id']}</td>
                                        <td>{$informacion['nombre']}</td>
                                        <td>{$informacion['apellidos']}</td>
                                        <td>{$informacion['especialidad']}</td>
                                    </tr>
                                ";
                            }
                        };
                    ?>
                </tbody>
            </table>
            <!-- cita en los próximos 7 dias -->
            <label>Consulta en los próximos 7 días</label>
            <?php
                if (isset($_POST['login']) && isset($_POST['medico'])) {
                    $medicoSelect=$_POST['medico'];
                    // combinar la tabla consulta con la de médico, encontrar todas citas dentro de 7 dias en orden ascendente 
                    //date_add es para conseguir la fecha despúes de 7 días
                    $select="SELECT c.fecha AS fecha, m.nombre AS nombre
                    FROM consulta c
                    INNER JOIN medico m ON c.id_medico=m.id
                    WHERE m.id=$medicoSelect AND DATE(c.fecha)>=CURDATE() AND DATE(c.fecha) <= DATE_ADD(CURDATE(),interval 7 day)
                    ORDER BY fecha ASC;";
                    $resulta=mysqli_query($conexion,$select);
                    if ($consulta=$resulta->num_rows>0) {
                        //si encontrar, va a presentar el nombre y la fecha
                        while ($consulta= $resulta->fetch_assoc()) {
                            echo "<p>Nombre de médico: {$consulta['nombre']}
                            | La fecha: {$consulta['fecha']}</p>";
                        }
                    } else {
                        //si no, va a salir un comentario
                        echo "<p>No tiene disponible de consulta en los próximos días</p>";
                    }
                };
            ?>
            
            <label>Consulta de hoy</label>
            <input type="hidden" name="idConsulta" value="<?php

                    $medicoSelect=$_POST['medico'];
                    // combinar la tabla consulta con la de médico y paciente ,encontrar todas citas que contienen médico, paciente, la fecha y síntoma de los primeros 100 caracteres de hoy en orden ascendente 
                    $select="SELECT c.id AS c_id 
                    FROM consulta c
                    INNER JOIN medico m ON c.id_medico=m.id
                    INNER JOIN pacientes p ON c.id_paciente=p.id
                    WHERE m.id=$medicoSelect AND DATE(c.fecha) =CURDATE()
                    ORDER BY c.fecha ASC;";
                    $resulta=mysqli_query($conexion,$select);
                    if ($consultaHoy=$resulta->num_rows>0) {
                        while ($consultaHoy= $resulta->fetch_assoc()) {
                            echo "{$consultaHoy['c_id']}";
                        }
                    }

            ?>">
            <?php
                if (isset($_POST['login']) && isset($_POST['medico'])) {
                    $medicoSelect=$_POST['medico'];
                    // combinar la tabla consulta con la de médico y paciente ,encontrar todas citas que contienen médico, paciente, la fecha y síntoma de los primeros 100 caracteres de hoy en orden ascendente 
                    $select="SELECT c.fecha AS fecha, m.nombre AS nombre, p.nombre AS p_nombre, c.id AS c_id ,LEFT(sintomatologia,100) AS sinto
                    FROM consulta c
                    INNER JOIN medico m ON c.id_medico=m.id
                    INNER JOIN pacientes p ON c.id_paciente=p.id
                    WHERE m.id=$medicoSelect AND DATE(c.fecha) =CURDATE()
                    ORDER BY c.fecha ASC;";
                    $resulta=mysqli_query($conexion,$select);
                    if ($consultaHoy=$resulta->num_rows>0) {
                        // fetch_assoc() se ultilzar para obtener cada fila de resulta de
                        while ($consultaHoy= $resulta->fetch_assoc()) {
                            echo "
                            <p>ID DE CONSULTA: {$consultaHoy['c_id']}</p>
                            <p>NOMBRE DE PACIENTE: {$consultaHoy['p_nombre']}</p>
                            <p>NOMBRE DE MÉDICO: {$consultaHoy['nombre']}</p>
                            <p>LA FECHA DE CONSULTA: {$consultaHoy['fecha']}</p>
                            <p>SINTOMATOLOGÍA: {$consultaHoy['sinto']}</p>
                            <input type='hidden' name='idConsulta' value='{$consultaHoy['c_id']}'/>
                            <input name='consulta' type='submit' value='Pasar Consulta'>
                            ";
                        }
                    } else {
                        echo "<p>No tiene disponible de consulta de hoy</p>";
                    }
                };
            ?>            
        </fieldset>
    </form>
    </div>
</body>
</html>
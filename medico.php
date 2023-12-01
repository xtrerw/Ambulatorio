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
    <header>
        <img src="img/logo.jpg" alt="" srcset="">
        <div>
            <a href="index.php">Inicia Sesión</a>
            <a href="consulta.php">Consulta</a>
            <a href="cita.php">Cita Previa</a>
        </div>
    </header>
    <div class="container">
    <form action="" method="post">
        <fieldset>
            <legend>
                Médico
            </legend>
            <label for="">Información de Médico</label>
            <table>
                <thead>
                    <tr>
                        <td>Nombre</td>
                        <td>Apellido</td>
                        <td>Especialidad</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (isset($_POST['login']) && isset($_POST['medico'])) {
                            $medicoSelect=$_POST['medico'];
                            $select="SELECT * FROM medico WHERE id='$medicoSelect'";
                            $resulta=mysqli_query($conexion,$select);
                            while ($informacion= $resulta->fetch_assoc()) {
                                echo "
                                    <tr>
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
            <label>Consulta en los próximas 7 días</label>
            <?php
                if (isset($_POST['login']) && isset($_POST['medico'])) {
                    $medicoSelect=$_POST['medico'];
                    $select="SELECT c.fecha AS fecha, m.nombre AS nombre
                    FROM consulta c
                    INNER JOIN medico m ON c.id_medico=m.id
                    WHERE m.id=$medicoSelect AND DATE(c.fecha)>=CURDATE() AND DATE(c.fecha) <= DATE_ADD(CURDATE(),interval 7 day)
                    ORDER BY fecha ASC;";
                    $resulta=mysqli_query($conexion,$select);
                    if ($consulta=$resulta->num_rows>0) {
                        while ($consulta= $resulta->fetch_assoc()) {
                            echo "<p>{$consulta['nombre']}</p>
                            <p>{$consulta['fecha']}</p>";
                        }
                    } else {
                        echo "<p>no tiene disponible de consulta en los próximos días</p>";
                    }
                };
            ?>
            <label>Consulta de hoy</label>
            <?php
                if (isset($_POST['login']) && isset($_POST['medico'])) {
                    $medicoSelect=$_POST['medico'];
                    $select="SELECT c.fecha AS fecha, m.nombre AS nombre
                    FROM consulta c
                    INNER JOIN medico m ON c.id_medico=m.id
                    WHERE m.id=$medicoSelect AND DATE(c.fecha) =CURDATE()
                    ORDER BY c.fecha ASC;";
                    $resulta=mysqli_query($conexion,$select);
                    if ($consultaHoy=$resulta->num_rows>0) {
                        while ($consultaHoy= $resulta->fetch_assoc()) {
                            echo "<p>{$consultaHoy['nombre']}</p>
                            <p>{$consultaHoy['fecha']}</p>";
                        }
                    } else {
                        echo "<p>hoy no tiene disponible de consulta</p>";
                    }
                };
            ?>
            <button>Consulta</button>
            </fieldset>
    </form>
    </div>
</body>
</html>7
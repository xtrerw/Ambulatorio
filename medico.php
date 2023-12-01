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
    <link rel="stylesheet" href="css/pacientes.css">
</head>
<body>
    <header>
        <img src="img/logo.jpg" alt="" srcset="">
        <div>
            <a href="index.php">Inicia Sesión</a>
            <a href="medico.php">Médico</a>
            <a href="cita.php">Cita Previa</a>
        </div>
    </header>
    <div class="container">
    <form action="" method="POST">
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
                        global $conexion;  
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
                        global $conexion;  
                        if (isset($_POST['login']) && isset($_POST['medico'])) {
                            $medicoSelect=$_POST['medico'];
                            $select="SELECT c.fecha AS fecha, m.nombre AS nombre
                            FROM medico m
                            INNER JOIN consulta c ON c.id_medio=m.id
                            WHERE id='$medicoSelect' AND DATE(c.fecha)>=CURDATE() AND DATE(c.fecha) < DATE_ADD(CURDATE(),interval 7 days)
                            ORDER BY c.fecha ASC
                            ;";
                            $resulta=mysqli_query($conexion,$select);
                            if ($informacion=$resulta->num_rows>0) {
                                while ($informacion= $resulta->fetch_assoc()) {
                                    echo "<p>{$informacion['nombre']}</p>
                                    <p>{$informacion['fecha']}</p>";
                                }
                            } else {
                                echo "<p>no tiene disponible de consulta en los próximos días</p>";
                            }
                        };
                    ?>
            <label>Consulta de hoy</label>
            
            </fieldset>
    </form>
    </div>
    <script type="text/javascript" src="pacientes.js"></script>
</body>
</html>7
<?php
include("tablas/crea_tablas.php");
//conseguir los datos de la id de paciente que inicia sesión
global $conexion;  
if (isset($_POST['login']) && isset($_POST['paciente'])) {
    $pacienteSelect=$_POST['paciente'];
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>
    <link rel="shortcut icon" href="img/logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="css/paciente.css">
</head>
<body>
    <!-- header -->
    <header>
        <img src="img/logo.jpg" alt="" srcset="">
        <div>
            <a href="index.php">Inicia Sesión</a>
            <a href='cita.php?paciente=<?php echo $pacienteSelect ?>'>Pedir una Cita</a>
        </div>
    </header>
    <!-- contenido -->
    <div class="container">
        <!-- formulario de información de paciente -->
    <form action="cita.php" method="post">
        <fieldset>
            <!-- título de formulario -->
            <legend>
                Paciente
            </legend>
            <!-- información -->
            <label for="">Información de Paciente</label>
            <table>
                <thead>
                    <tr>
                        <td>DNI</td>
                        <td>Nombre</td>
                        <td>Apellido</td>
                        <td>Fecha de nacionamiento</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        global $conexion;  
                            $select="SELECT DISTINCT * FROM pacientes WHERE id='$pacienteSelect'";
                            $resulta=mysqli_query($conexion,$select);
                            while ($informacion= $resulta->fetch_assoc()) {
                                echo "
                                    <tr>
                                        <td>{$informacion['dni']}</td>
                                        <td>{$informacion['nombre']}</td>
                                        <td>{$informacion['apellido']}</td>
                                        <td>{$informacion['fecha_nac']}</td>
                                    </tr>
                                ";
                            };
                    ?>
                </tbody>
            </table>
            <!-- citas pasadas -->
            <label>Citas Pasadas</label>
            <table>
                    <thead>
                        <td>ID de Consulta</td>
                        <td>Médico</td>
                        <td>Fecha</td>
                    </thead>
                    <tbody>
                        <?php 
                            if (isset($_POST['login']) && isset($_POST['paciente'])) {
                                # code...
                            $select = "SELECT DISTINCT c.id AS cita_id, m.nombre AS medico_nombre, m.apellidos AS medico_apellidos, c.fecha AS fecha
                            FROM consulta c
                            INNER JOIN medico m ON c.id_medico = m.id
                            WHERE c.id_paciente = $pacienteSelect AND DATE(c.fecha) < CURDATE()
                            ORDER BY c.fecha ASC";
                            $resulta=mysqli_query($conexion,$select);
                            if ($pasado=$resulta->num_rows > 0) {
                                # code...
                                while ($pasado=$resulta->fetch_assoc()) {
                                    # code...
                                    echo "
                                    <tr>
                                        <td>{$pasado['cita_id']}</td>
                                        <td>{$pasado['medico_nombre']}</td>
                                        <td>{$pasado['fecha']}</td>
                                    </tr>
                                    ";
                                }
                            } else{
                                echo "
                                <tr>
                                    <td colspan='3'>no tenía ningúna cita anterior</td>
                                </tr>
                                ";
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <!-- citas próximas -->
            <label>Próximas Citas</label>
            <table>
                <thead>
                    <td>ID de Consulta</td>
                    <td>Médico</td>
                    <td>Fecha</td>
                </thead>
                <tbody>
                    <?php 
                        if (isset($_POST['login']) && isset($_POST['paciente'])) {
                            $select = "SELECT DISTINCT c.id AS cita_id, m.nombre AS medico_nombre, m.Apellidos AS medico_apellidos, c.fecha
                            FROM consulta c
                            INNER JOIN medico m ON c.id_medico = m.id
                            WHERE c.id_paciente = $pacienteSelect AND DATE(c.fecha) >= CURDATE()
                            ORDER BY c.fecha ASC";
                            $resulta=mysqli_query($conexion,$select);
                            if ($proximaCita=$resulta->num_rows > 0) {
                                while ($proximaCita=$resulta->fetch_assoc()) {
                                    echo "
                                    <tr>
                                        <td>{$proximaCita['cita_id']}</td>
                                        <td>{$proximaCita['medico_nombre']}</td>
                                        <td>{$proximaCita['fecha']}</td>
                                    </tr>
                                    ";
                                }
                            } else {
                                echo "
                                <tr>
                                    <td colspan='3'>no tiene ningún próxima cita</td>
                                </tr>
                                ";
                            }
                        }
                    ?>
                </tbody>
            </table>
            </fieldset>
            <!-- medicación actual -->
            <fieldset>
            <legend>Medicación actual</legend>
            <?php
                if (isset($_POST['login']) && isset($_POST['paciente'])) {
                    # combinar la tabla consulta con la de medicamento y paciente, encontrar todas informaciones de síntoma que surgen y medicamento necesario 
                    $select="SELECT  r.posologia AS posologia, r.fecha_fin AS fecha_fin, c.sintomatologia AS sinto, p.nombre AS nombre,m.medicamento AS medicamento, c.diagnostico AS diagnostico, c.id AS id
                    FROM receta r
                    INNER JOIN consulta c ON r.id_consulta=c.id
                    INNER JOIN medicamento m ON r.id_medicamento=m.id
                    INNER JOIN pacientes p ON c.id_paciente=p.id
                    WHERE c.id_paciente=$pacienteSelect AND r.fecha_fin>=CURDATE()
                    ORDER BY c.fecha DESC LIMIT 1";
                    $resulta=mysqli_query($conexion,$select);
                    if ($medicacion=$resulta->num_rows > 0) {
                        # si encontrar ....
                        while ($medicacion=$resulta->fetch_assoc()) {
                            # presentar las informaciones
                            echo "<p>Nombre de Paciente</p>
                            <p>{$medicacion['nombre']}</p>
                            <p>Medicamento</p>
                            <p>{$medicacion['medicamento']}</p>
                            <p>La fecha final</p>
                            <p>{$medicacion['fecha_fin']}</p>
                            <p>Posologia</p>
                            <p>{$medicacion['posologia']}</p>
                            <p>Diágnostico</p>
                            <p>{$medicacion['diagnostico']}</p>
                            <p>Sintomatología</p>
                            <p>{$medicacion['sinto']}</p>
                            ";
                        }
                    } else {
                        //si no, sale este comentario
                        echo "Este paciente no existe ninguna sintomatologia";
                    }
                }
            ?>
            </fieldset>
    </form>
    </div>
</body>
</html>
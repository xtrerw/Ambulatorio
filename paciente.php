<?php
include("tablas/crea_tablas.php");
              
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
    <header>
        <div>

        </div>
    </header>
    <form action="" method="POST">
        <fieldset>
            <legend>
                <h1>Paciente</h1>
            </legend>
            <label for="">Información de Paciente</label>
            <table border="1px">
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
                        if (isset($_POST['login']) && isset($_POST['paciente'])) {
                            $pacienteSelect=$_POST['paciente'];
                            $pacienteSelect=mysqli_real_escape_string($conexion,$pacienteSelect);
                            $select="SELECT * FROM pacientes WHERE id='$pacienteSelect'";
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
                            }
                        };
                    ?>
                </tbody>
            </table>
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
                                $pacienteSelect=$_POST["paciente"];
                            $select = "SELECT c.id AS cita_id, m.nombre AS medico_nombre, m.Apellidos AS medico_apellidos, c.fecha
                            FROM consulta c
                            INNER JOIN medico m ON c.id_medico = m.id
                            WHERE c.id_paciente = $pacienteSelect AND DATE(c.fecha) < CURDATE()
                            ORDER BY c.fecha ASC";
                            $resulta=mysqli_query($conexion,$select);
                            if ($pasado=$resulta->fetch_assoc()>0) {
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
            <label>Medicación actual</label>
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
                                $pacienteSelect=$_POST["paciente"];
                                $select = "SELECT c.id AS cita_id, m.nombre AS medico_nombre, m.Apellidos AS medico_apellidos, c.fecha
                                FROM consulta c
                                INNER JOIN medico m ON c.id_medico = m.id
                                WHERE c.id_paciente = $pacienteSelect AND DATE(c.fecha) >= CURDATE()
                                ORDER BY c.fecha ASC";
                                $resulta=mysqli_query($conexion,$select);
                                if ($proxima=$resulta->fetch_assoc() > 0) {
                                    while ($proxima=$resulta->fetch_assoc()) {
                                        echo "
                                        <tr>
                                            <td>{$proxima['cita_id']}</td>
                                            <td>{$proxima['medico_nombre']}</td>
                                            <td>{$proxima['fecha']}</td>
                                        </tr>
                                        ";
                                    }
                                } else {
                                    echo "
                                    <tr>
                                        <td colspan='3'>no tenía ningúna cita próxima</td>
                                    </tr>
                                    ";
                                }
                            }
                        ?>
                    </tbody>
                </table>
            <label>Pedir una cita</label>
            <input type="date" name="fecha" id="">
            <select name="medico" id="">
                <?php 
                    $select = "SELECT DISTINCT * FROM medico";
                    $resulta = mysqli_query($conexion,$select); 
                    while ($medico = $resulta->fetch_assoc()) {
                        echo "<option value='{$medico['id']}'>{$medico['nombre']} {$medico['apellidos']}-{$medico['especialidad']}</option>";
                    }
                ?>
            </select>
        </fieldset>
        <input type="submit" value="Pedir una cita" name="registro">
    </form>
    <script type="text/javascript" src="pacientes.js"></script>
</body>
</html>
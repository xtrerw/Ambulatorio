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
        <legend>Consulta</legend>
        <fieldset>
            <legend>
                Información de Médico y Paciente
            </legend>
            <table>
                <thead>
                    <tr>
                        <td>Médico</td>
                        <td>Paciente</td>
                        <td>Fecha</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (isset($_POST['consulta'])) {
                            session_start();
                            $medicoSelect=$_SESSION["idMedico"];
                            $select="SELECT m.nombre AS medico,p.nombre AS paciente, c.fecha AS fecha
                            FROM consulta c
                            INNER JOIN medico m ON c.id_medico=m.id
                            INNER JOIN pacientes p ON c.id_paciente=p.id 
                            WHERE c.id='$medicoSelect'";
                            $resulta=mysqli_query($conexion,$select);
                            while ($informacion= $resulta->fetch_assoc()) {
                                echo "
                                    <tr>
                                        <td>{$informacion['medico']}</td>
                                        <td>{$informacion['paciente']}</td>
                                        <td>{$informacion['fecha']}</td>
                                    </tr>
                                ";
                            }
                        };
                    ?>
                </tbody>
            </table>
            </fieldset>
            <fieldset>
                <legend>
                Sintomatología
                </legend>
                <textarea name="sintomatologia" id="" cols="50" rows="10">
                <?php
                    if (isset($_POST['consulta'])) {
                        session_start();
                        $medicoSelect=$_SESSION["idMedico"];
                        $select="SELECT c.sintomatologia AS sinto
                        FROM consulta c
                        INNER JOIN medico m ON c.id_medico=m.id
                        WHERE c.id='$medicoSelect'";
                        $resulta=mysqli_query($conexion,$select);
                        while ($informacion= $resulta->fetch_assoc()) {
                            echo "{$informacion['sinto']}";
                        }
                    };
                ?>
            </textarea>
            </fieldset>
            <fieldset>
            <legend>Diagnóstico</legend>
            <textarea name="diagnostico" id="" cols="50" rows="10">
                <?php
                    if (isset($_POST['consulta'])) {
                        session_start();
                        $medicoSelect=$_SESSION["idMedico"];
                        $select="SELECT c.diagnostico AS diagnostico
                        FROM consulta c
                        INNER JOIN medico m ON c.id_medico=m.id
                        WHERE c.id='$medicoSelect'";
                        $resulta=mysqli_query($conexion,$select);
                        while ($informacion= $resulta->fetch_assoc()) {
                            echo "{$informacion['diagnostico']}";
                        }
                    };
                ?>
            </textarea>
            </fieldset>
            <fieldset>
                <legend>Medicación</legend>
                <label for="">Medicamentos</label>
                <select name="medicamentos" id="">
                    <option value="poción de vida">poción de vida</option>
                    <option value="amoxicilina">amoxicilina</option>
                    <option value="aspirina">aspirina</option>
                    <option value="formalina">formalina</option>
                    <option value="naproxeno">naproxeno</option>
                    <option value="Vitamina B12">vitamina B12</option>
                </select>
                <label for="">Cantidad</label>
                <input type="text" name="cantidad">
                <label for="">Frecuencia</label>
                <input type="text" name="hora">
                <input type="text" name="day">
                <label for="">Medicación es crónica</label>
            </fieldset>
            
    </form>
    </div>
</body>
</html>7
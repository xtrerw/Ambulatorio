<?php
include("tablas/crea_tablas.php");          
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedir Cita</title>
    <link rel="shortcut icon" href="img/logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="css/cita.css">
    <script type="text/javascript" src="js/calendar.js"></script>
    <style type="text/css">@import url("js/calendar-blue.css");</style>
    <script type="text/javascript" src="js/calendar-es.js"></script>
    <script type="text/javascript" src="js/calendar-setup.js"></script>

</head>
<body>
    <header>
        <img src="img/logo.jpg" alt="" srcset="">
        <div>
            <a href="index.php">Inicial Sesión</a>
        </div>
    </header>
    <div class="container">
        <form action="" method="POST">
            <fieldset>
                <legend>
                    Pedir una cita
                </legend>
                <label>Seleciona una fecha disponible</label>
                <input type="text" name="cita" id="cita" readonly="readonly" onchange="fecha();" require>
                <img src="img/calendario.png" alt="" width="30" id="selector">
                <label>Seleciona un médico</label>
                <select name="medico" id="">
                    <?php 
                        $select = "SELECT DISTINCT * FROM medico";
                        $resulta = mysqli_query($conexion,$select); 
                        while ($medico = $resulta->fetch_assoc()) {
                            echo "<option value='{$medico['id']}'>{$medico['nombre']} {$medico['apellidos']}-{$medico['especialidad']}</option>";
                        }
                    ?>
                </select>
                <label>Sintomatología</label>
                <textarea name="" id="" cols="30" rows="10">
                <?php
                    session_start();
                    $pacienteSelect=$_SESSION["idPaciente"];
                    $select="SELECT c.sintomatologia AS sinto
                    FROM consulta c
                    INNER JOIN pacientes p ON c.id_paciente=p.id
                    WHERE c.id=$pacienteSelect";
                    $resulta=mysqli_query($conexion,$select);
                    while ($informacion= $resulta->fetch_assoc()) {
                        echo "{$informacion['sinto']}";
                    }
                ?>
                </textarea>
                <label id="advertencia"></label>
                <input type="submit" value="Pedir una cita" name="registro" id="registro">
            </fieldset>
        </form>
    </div>
    <script type="text/javascript" src="js/cita.js"></script>
</body>
</html>
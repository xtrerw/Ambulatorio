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
</head>
<body>
    <header>
        <img src="img/logo.jpg" alt="" srcset="">
        <div>
            <a href="index.php">Inicial Sesión</a>
            <a href="medico.php">Médico</a>
            <a href="cita.php">Cita Previa</a>
        </div>
    </header>
    <div class="container">
    <form action="" method="POST">
        <fieldset>
            <legend>
                Pedir una cita
            </legend>
    <form action="">
    <label>Seleciona una fecha disponible</label>
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
        <input type="submit" value="Pedir una cita" name="registro">
    </form>
    </div>
    <script type="text/javascript" src="pacientes.js"></script>
</body>
</html>
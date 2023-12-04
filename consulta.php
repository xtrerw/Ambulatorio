<?php
include("tablas/crea_tablas.php");
//conseguir id de consulta
$consultaID=$_POST["consultaHoy"]; 
if (isset($_POST["add"]) && $_POST["sintomatologia"]) {
    # actualiza la síntoma que este médico ya ha apuntado al paciente
    $sintoma=$_POST["sintomatologia"];
    $update="UPDATE consulta 
    SET sintomatologia='$sintoma'
    WHERE id=$consultaID";
    mysqli_query($conexion,$update);
}
//conseguir diagnostico
if (isset($_POST["add"]) && $_POST["diagnostico"]) {
    # actualiza el diagnóstico de consulta
    $diagnostico=$_POST["diagnostico"];
    $update="UPDATE consulta 
    SET diagnostico='$diagnostico'
    WHERE id=$consultaID";
    mysqli_query($conexion,$update);
}
//conseguir el medicamento, cantidad y frecuencia etc
if (isset($_POST["add"]) && $_POST["medicamento"]) {
    # actualiza el id de medicamento de la tabla receta
    $medicamentoID=$_POST["medicamento"];
    $update="UPDATE medicamento
    SET id_medicamento=$medicamentoID
    WHERE id_consulta=$consultaID";
    mysqli_query($conexion,$update);
}  
if (isset($_POST["add"]) && $_POST["cantidad"]) {
    # actualiza el id de medicamento de la tabla receta
    $cantidad=$_POST["cantidad"];
    $hora=$_POST["hora"];
    $dia=$_POST["dia"];
    $update="UPDATE medicamento
    SET posologia='$cantidad/$hora' AND fecha_fin=DATE_ADD(CURDATE(),interval $dia day)
    WHERE id_consulta=$consultaID";
    mysqli_query($conexion,$update);
}  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Médico</title>
    <link rel="shortcut icon" href="img/logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="css/consulta.css">
</head>
<body>
    <!-- header -->
    <header>
        <img src="img/logo.jpg" alt="" srcset="">
        <div>
            <a href="index.php">Inicia Sesión</a>
            <a href="cita.php"> Pedir una Cita</a>
        </div>
    </header>
    <!-- contenido -->
    <div class="container">
    <!-- formulario de consulta -->
    <form action="" method="post">
        <legend>Consulta</legend>
        <fieldset>
            <!-- información de cita de hoy -->
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
                        if (isset($_POST['consulta']) && isset($_POST['consultaHoy'])) {
                            $consultaID=$_POST['consultaHoy'];
                            $select="SELECT m.nombre AS medico,p.nombre AS paciente, c.fecha AS fecha
                            FROM consulta c
                            INNER JOIN medico m ON c.id_medico=m.id
                            INNER JOIN pacientes p ON c.id_paciente=p.id 
                            WHERE c.id=$consultaID";
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
        <!-- síntoma que puede modifcar el medico -->
        <fieldset>
            <legend>
            Sintomatología
            </legend>
            <div name="sintomatologia">
                <?php
                    if (isset($_POST['consulta']) && isset($_POST['consultaHoy'])) {
                        $consultaID=$_POST['consultaHoy'];
                        $select="SELECT c.sintomatologia AS sinto
                        FROM consulta c
                        INNER JOIN medico m ON c.id_medico=m.id
                        WHERE c.id=$consultaID";
                        $resulta=mysqli_query($conexion,$select);
                        while ($informacion= $resulta->fetch_assoc()) {
                            echo "<textarea cols='100' rows='10'>{$informacion['sinto']}</textarea>";
                        }
                    };
                ?>
            </div>
        </fieldset>
        <fieldset>
        <!-- diagnóstico que también puede modifcar -->
            <legend>Diagnóstico</legend>
            <div name="diagnostico">
                <?php
                    if (isset($_POST['consulta']) && isset($_POST['consultaHoy'])) {
                        $consultaID=$_POST['consultaHoy'];
                        $select="SELECT c.diagnostico AS diagnostico
                        FROM consulta c
                        INNER JOIN medico m ON c.id_medico=m.id
                        WHERE c.id=$consultaID";
                        $resulta=mysqli_query($conexion,$select);
                        while ($informacion= $resulta->fetch_assoc()) {
                            echo "<textarea name='diagnostico' id='' cols='100' rows='10'>{$informacion['diagnostico']}</textarea>";
                        }
                    };
                ?>
            
        </fieldset>
        <!-- medicamento que recomenda el médico -->
        <fieldset>
            <legend>Medicación</legend>
            <label for="">Medicamentos</label>
            <select name="medicamentos" id="">
                <?php
                    if (isset($_POST['consulta']) && isset($_POST['consultaHoy'])) {
                        $select="SELECT * FROM medicamento";
                        $resulta=mysqli_query($conexion,$select);
                        while ($medicamento= $resulta->fetch_assoc()) {
                            echo "<option value='{$medicamento['id']}'>{$medicamento['medicamento']}</option>";
                        }
                    };
                ?>
            </select>
            <label for="">Cantidad</label>
            <input type="text" maxlength="100 " name="cantidad" placeholder="eje: media pastilla" require>
            <label for="">Frecuencia</label>
            <input type="text" maxlength="100" name="hora" placeholder="eje: cada 8 hora" require>
            <input type="number" maxlength="100" id="dia" name="dia" placeholder="eje: 3 días" require>
            <label for="">
                ¿La medicación si es crónica?
                <input type="checkbox" name="dia" value="365" id="cronica" onchange="check();">Sí
            </label>
        </fieldset>
        <button name="add">Añadir Medicación</button>
    </form>
    </div>
    
    <script type="text/javascript" src="js/consulta.js"></script>
</body>
</html>7
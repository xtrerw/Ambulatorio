<?php
include("tablas/crea_tablas.php");
global $conexion;
//conseguir id consulta desde la página login de médico.
$idConsulta=$_POST["idConsulta"];
if (isset($_POST["add"]) && isset($_POST["sintomatologia"])) {
    # actualizar la sintomatología en la tabla consulta
    $sintoma=$_POST["sintomatologia"];
    $sintoma=mysqli_escape_string($conexion,$sintoma);
    $update="UPDATE consulta 
    SET sintomatologia='$sintoma'
    WHERE id=$idConsulta";
    mysqli_query($conexion,$update);
}
if (isset($_POST["add"]) && isset($_POST["diagnostico"])) {
    # actualiza diagnóstico apuntado
    $diagnostico=$_POST["diagnostico"];
    $update="UPDATE consulta 
    SET diagnostico='$diagnostico'
    WHERE id=$idConsulta";
    mysqli_query($conexion,$update);
}
if (isset($_POST["add"])) {
    # inserta la cantidad ,frecuencia etc de medicamento
    $cantidad=$_POST["cantidad"];
    $cantidad=mysqli_escape_string($conexion,$cantidad);
    $hora=$_POST["hora"];
    $hora=mysqli_escape_string($conexion,$hora);
    $medicamento=$_POST["medicamento"];
    $dia=$_POST["dia"];
    $insert="INSERT INTO receta(id_medicamento,id_consulta,posologia,fecha_fin)
    VALUES($medicamento,$idConsulta,'$cantidad/$hora',DATE_ADD(NOW(), INTERVAL $dia DAY))";
    mysqli_query($conexion,$insert);
}
if (isset($_POST["add"])) {
    # subir el pdf
    // si ya subido, pues guardar en la archivo pdf
    $directorio_subida = "pdf/";// crear el directorio para guadar pdf
    $archivo = $_FILES["archivo"]['name'];
    $archivoTmp = $_FILES["archivo"]['tmp_name'];
    $ruta_completa=$directorio_subida . $archivo;
    move_uploaded_file($archivoTmp,$ruta_completa);//mover fichero al directorio
    $archivo=mysqli_escape_string($conexion,$archivo);
    $update="UPDATE consulta SET archivo='$archivo' WHERE id=$idConsulta";// para guardar nombre de fichero enviado
    mysqli_query($conexion,$update);
}
//
if (isset($_POST["pedir"]) && isset($_POST["cita"])) {
    # actualiza la fecha que este médico elige para este paciente
    $fecha=$_POST["cita"];
    $fecha=mysqli_escape_string($conexion,$fecha);
    $update="UPDATE consulta 
    SET fecha='$fecha'
    WHERE id=$idConsulta";
    mysqli_query($conexion,$update);
}
//conseguir id de médico selecionado de la cita
if (isset($_POST["pedir"]) && isset($_POST["medico"])) {
    # actualiza el médico que elige en la tabla consulta y la paciente
    $medico=$_POST["medico"];
    $update="UPDATE  pacientes p
    INNER JOIN consulta c ON c.id_paciente=p.id
    SET id_med=$medico,c.id_medico=$medico
    WHERE c.id=$idConsulta";
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
    <link rel="stylesheet" href="css/consultas.css">

    <script type="text/javascript" src="js/calendar.js"></script>
    <style type="text/css">@import url("js/calendar-blue.css");</style>
    <script type="text/javascript" src="js/calendar-es.js"></script>
    <script type="text/javascript" src="js/calendar-setup.js"></script>
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
    <!-- formulario de consulta -->
    <form action="" method="post" enctype="multipart/form-data">
        <legend>Consulta</legend>
        <fieldset>
            <!-- información de consulta según la página anterior -->
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
                    <!-- mostrar la información -->
                    <?php
                        $select="SELECT m.nombre AS medico,p.nombre AS paciente, c.fecha AS fecha
                        FROM consulta c
                        INNER JOIN medico m ON c.id_medico=m.id
                        INNER JOIN pacientes p ON c.id_paciente=p.id 
                        WHERE c.id=$idConsulta";
                        $resulta=mysqli_query($conexion,$select);
                        while ($informacion= $resulta->fetch_assoc()) {
                            echo "
                                <tr>
                                    <td>{$informacion['medico']}</td>
                                    <td>{$informacion['paciente']}</td>
                                    <td>{$informacion['fecha']}</td>
                                </tr>
                            ";
                        };
                    ?>
                </tbody>
            </table>
            <!-- síntoma que puede modifcar el medico -->
            <legend>
            Sintomatología
            </legend>
            <div name="sintomatologia">
                <?php
                    $select="SELECT c.sintomatologia AS sinto
                    FROM consulta c
                    INNER JOIN medico m ON c.id_medico=m.id
                    WHERE c.id=$idConsulta";
                    $resulta=mysqli_query($conexion,$select);
                    while ($informacion= $resulta->fetch_assoc()) {
                        echo "<textarea cols='100' rows='10'>{$informacion['sinto']}</textarea>";
                    };
                ?>
            </div>
            <!-- diagnóstico que también puede modifcar -->
            <legend>Diagnóstico</legend>
            <div name="diagnostico">
                <?php
                    $select="SELECT c.diagnostico AS diagnostico
                    FROM consulta c
                    INNER JOIN medico m ON c.id_medico=m.id
                    WHERE c.id=$idConsulta";
                    $resulta=mysqli_query($conexion,$select);
                    while ($informacion= $resulta->fetch_assoc()) {
                        echo "<textarea name='diagnostico' id='' cols='100' rows='10'>{$informacion['diagnostico']}</textarea>";
                    };
                ?>
            </div>
        <!-- medicamento que recomenda el médico -->
            <legend>Medicación</legend>
            <label for="">Medicamentos</label>
            <select name="medicamento" id="">
                <?php
                // selecciona medicamento que tiene
                        $select="SELECT DISTINCT * FROM medicamento";
                        $resulta=mysqli_query($conexion,$select);
                        while ($medicamento= $resulta->fetch_assoc()) {
                            echo "<option value='{$medicamento['id']}'>{$medicamento['medicamento']}</option>";
                        };
                ?>
            </select>
            <!-- cantidad de uso de medicamentos -->
            <label for="">Cantidad</label>
            <input type="text" maxlength="100 " name="cantidad" placeholder="eje: media pastilla" require>
            <!-- frecuencia de uso de medicamento -->
            <label for="">Frecuencia</label>
            <!-- hora de día -->
            <input type="text" maxlength="100" name="hora" placeholder="eje: cada 8 hora" require>
            <!-- duración de uso de pastilla -->
            <input type="number" maxlength="100" id="dia" name="dia" placeholder="eje: 3 días">
            <!-- comprobar si es medicación crónica, si es, pues valor de duración de uso pastilla será 365 días-->
            <label for="">
                ¿La medicación si es crónica?
                <input type="checkbox" id="cronica" onchange="check();">Sí
            </label>
            <!-- agregar la columna de guardar los archivos -->
            <?php
            $columnExists = mysqli_query($conexion, "SHOW COLUMNS FROM `consulta` LIKE 'archivo'");
            // crear columna "archivo" en tabla consulta
            if(mysqli_num_rows($columnExists) == 0) {
                $columna="ALTER TABLE consulta ADD COLUMN archivo VARCHAR(255);";
                mysqli_query($conexion,$columna);
            }
            ?>
            <label for="archivo">Selecciona un archivo PDF:</label>
            <input type="file" name="archivo" id="archivo" accept=".pdf">
            <!-- input es para ulitilizar $_POST con id de consulta que almacenar cuando subimos los datos, si no hace así,me va a poner error que hay nulo de id de consulta -->
            <input type="hidden" name="idConsulta" value="<?php echo $idConsulta ?>" />
        </fieldset>
        <!-- bóton de añadir medicación -->
        <input type="submit" name="add" id="add" value="Añadir Medicación">
    </form>
    <!-- muestra información de añadir medicamento y sintomatología apuntada -->
    <label>
    <?php 
        if (isset($_POST["add"])) {
            // combinar la tabla consulta con la de médico y paciente para obtener informacion introducida 
                $select="SELECT m.nombre AS medico,p.nombre AS paciente, c.sintomatologia AS sintoma
                FROM consulta c
                INNER JOIN medico m ON c.id_medico=m.id
                INNER JOIN pacientes p ON c.id_paciente=p.id 
                WHERE c.id=$idConsulta";
                $resulta=mysqli_query($conexion,$select);
                while ($informacion= $resulta->fetch_assoc()) {
                    echo "
                        Médico: {$informacion['medico']}<br>
                        Paciente: {$informacion['paciente']}<br>
                        Su síntoma: {$informacion['sintoma']}<br>
                        Diagnóstico: $diagnostico<br>";
                };
            // combinar la tabla receta con medicamento para obtener cantidad de medicamento
            // va a PDF subido por etiqueta ancla
                $select="SELECT DISTINCT m.medicamento AS medicamento 
                FROM receta r
                INNER JOIN medicamento m ON m.id=r.id_medicamento 
                WHERE  id_consulta=$idConsulta";
                $resulta=mysqli_query($conexion,$select);
                while ($medica= $resulta->fetch_assoc()) {
                echo "Ya añadir medicamento: {$medica['medicamento']}<br>
                Cantidad: $cantidad<br>
                Horas: $hora<br>
                Dia: $dia<br>
                <a href='$directorio_subida$archivo'>Ver pdf</a>";
                }
            }   
    ?>
    </label>
    
        <!-- cita para paciente -->
        <form action="" method="post" class="formRegistro">
                <legend>
                    Derivar a especialista
                </legend>
            <fieldset>
                <!-- Título de la página -->
                <legend>Cita en futuro</legend>
                <!-- Médico selecionado -->
                <label>Seleciona un médico</label>
                <!-- es para que el médico puede elige otra médico en la cita próxima del paciente  -->
                <select name="medico" id="">
                    <?php 
                        //conseguir todos los médicos
                        $select = "SELECT DISTINCT * FROM medico";
                        $resulta = mysqli_query($conexion,$select); 
                        while ($medico = $resulta->fetch_assoc()) {
                            echo "<option value='{$medico['id']}'>{$medico['nombre']} {$medico['apellidos']}-{$medico['especialidad']}</option>";
                        }
                    ?>
                </select>
                <!-- Fecha seleccionada -->
                <label>Seleciona una fecha disponible</label>
                <!-- cuando el médico elige una fecha de la cita, va a aparecer aquí   -->
                <input type="text" name="cita" id="cita" readonly="readonly" onchange="fecha();" require>
                <!-- una imagen se funciona como un selector de fecha  -->
                <img src="img/calendario.png" alt="" width="30" id="selector">
                <!-- advertencia -->
                <label id="advertencia"></label>
                <!-- input es para subir los datos con id de consulta que almacenar, si no hace así,me va a poner error que no busca id de consulta -->
                <input type="hidden" name="idConsulta" value="<?php echo $idConsulta ?>" />
                <!-- bóton para subir cita -->
                <input type="submit" value="Registro" name="pedir" id="pedir">
            </fieldset>
        </form>
        <!-- muestra información de cita modificado -->
        <label>
        <?php 
            if (isset($_POST["pedir"])) {
                $select="SELECT m.nombre AS medico,p.nombre AS paciente,c.fecha AS fecha
                FROM consulta c
                INNER JOIN medico m ON c.id_medico=m.id
                INNER JOIN pacientes p ON c.id_paciente=p.id 
                WHERE c.id=$idConsulta";
                $resulta=mysqli_query($conexion,$select);
                while ($informacion= $resulta->fetch_assoc()) {
                    echo "La cita ya cambiado <br>
                        Médico: {$informacion['medico']}<br>
                        Paciente: {$informacion['paciente']}<br>
                        La fecha cambiado: {$informacion['fecha']}<br>
                        ";
                };
            }
        ?>
        </label>
    </div>
    <script type="text/javascript" src="js/consulta.js"></script>
</body>
</html>
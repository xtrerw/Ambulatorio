<?php
include("tablas/crea_tablas.php");
              
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>
    <link rel="stylesheet" href="css/pacientes.css">
</head>
<body>
    <!-- <form action="./clase/medicamentos.php" method="post">
        <h1>Consulta</h1>
        <h2>Información</h2>
        <p>médico</p>
        <h2></h2>
        <label>Sintomatología</label>
        <textarea name="sintomatologia" id="" cols="30" rows="10"></textarea>
        <label for="">Diagnóstico</label>
        <textarea name="diagnostico" id="" cols="30" rows="10"></textarea>
        <label>Medicamentos</label>
        <select name="medico" id="">

                //     $select = "SELECT DISTINCT * FROM medicamento";
                //     $resulta = mysqli_query($conexion,$select); 
                // while ($rows = $resulta->fetch_assoc()) {
                //     echo "<option value='{$rows['id']}'>{$rows['medicamento']}</option>";
                //     }

        </select>
        <label for="">Cantidad</label>
        <input type="text" name="" id="">
        <label for="">Frecuencia:
        <input type="text" name="" id="">
        <input type="number" name="" id="" >días
        </label>
        <input type="submit" value="Añadir medicación">
    </form> -->
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <fieldset>
            <legend>
                <h1>Paciente</h1>
            </legend>
            <label for="">Información de Paciente</label>
            <?php
                global $conexion;  
                if (isset($_POST['paciente'])) {
                    $pacienteSelect=$_POST['paciente'];
                    $pacienteSelect=mysqli_real_escape_string($conexion,$pacienteSelect);
                    $select="SELECT * FROM pacientes WHERE id='$pacienteSelect'";
                    $resulta=mysqli_query($conexion,$select);
                    while ($informacion= $resulta->fetch_assoc()) {
                        echo "<p>{$informacion['nombre']}</p>";
                    }
                };
            ?>
            <label>Próximas citas</label>
                <table>
                    <thead>
                        <td>ID</td>
                        <td>Médico</td>
                        <td>Fecha</td>
                    </thead>
                    <tbody>
                        <?php 
                            $select="SELECT DISTINCT * FROM consulta";
                            $resulta=mysqli_query($conexion,$select);
                            while ($consulta=$resulta->fetch_assoc()) {
                                # code...
                                echo "
                                <tr>
                                    <td>{$consulta['id']}</td>
                                    <td>{$consulta['id_medico']}</td>
                                    <td>{$consulta['fecha']}</td>
                                </tr>
                                ";
                            }
                        ?>
                    </tbody>
                </table>
            <label>Medicación actual</label>
            <label>Consulta pasadas</label>
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
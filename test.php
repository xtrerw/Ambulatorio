<?php
include 'tablas/crea_tablas.php';

// Obtener la lista de médicos
$sqlMedicos = "SELECT * FROM medico";
$resultadoMedicos = getConexion()->query($sqlMedicos);

// Inicializar la variable del ID del médico seleccionado
$idMedicoSeleccionado = null;

// Verificar si se ha seleccionado un médico
if (isset($_POST['id_medico'])) {
    $idMedicoSeleccionado = $_POST['id_medico'];
}

// Obtener información del médico seleccionado
if ($idMedicoSeleccionado) {
    $sqlInfoMedico = "SELECT * FROM medico WHERE id = '$idMedicoSeleccionado'";
    $resultadoInfoMedico = getConexion()->query($sqlInfoMedico);

    if ($resultadoInfoMedico->num_rows > 0) {
        $infoMedico = $resultadoInfoMedico->fetch_assoc();
    } else {
        $infoMedico = array(); // Puedes manejar el caso en que no se encuentre el médico
    }

    // Obtener todas las consultas para el médico
    $sqlConsultas = "SELECT c.id_consulta, c.Fecha_consulta, p.Nombre AS NombrePaciente, SUBSTRING(c.Sintomatologia, 1, 100) AS ExtractoSintomatologia
                     FROM consulta c
                     JOIN paciente p ON c.id_paciente = p.id
                     WHERE c.id_medico = '$idMedicoSeleccionado'";
    $resultadoConsultas = getConexion()->query($sqlConsultas);
}

getConexion()->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css\styles.css">
    <title>Página de Médico</title>
</head>

<body>
<header>
<div class="topnav">
  <div class="logo"><img src="img\estetos.png" alt=""></div>
  <a class="active" href="#home"> HealthHub</a>
  <a href="#news">News</a>
  <a href="#contact">Contact</a>
  <a href="#about">About</a>
</div>
    <h1>Información del Médico</h1>
    <form action="medico.php" method="post">
        <label for="medicos">Selecciona un médico:</label>
        <select id="medicos" name="id_medico" onchange="this.form.submit()">
            <?php
            while ($row = $resultadoMedicos->fetch_assoc()) {
                $selected = ($row['id'] == $idMedicoSeleccionado) ? 'selected' : '';
                echo "<option value='{$row['id']}' $selected>{$row['Nombre']} {$row['Apellidos']} - {$row['Especialidad']}</option>";
            }
            ?>
        </select>
    </form>
    <p><?php echo isset($infoMedico['Nombre']) ? $infoMedico['Nombre'] . ' ' . $infoMedico['Apellidos'] . ' - ' . $infoMedico['Especialidad'] : 'Médico'; ?></p>
</header>

<?php if ($idMedicoSeleccionado) : ?>
    <?php if ($resultadoConsultas->num_rows > 0) : ?>
        <section>
            <h2>Consultas</h2>
            <ul>
                <?php
                while ($consulta = $resultadoConsultas->fetch_assoc()) {
                    echo "<li>ID de Cita: {$consulta['id_consulta']}, Fecha: {$consulta['Fecha_consulta']}, Paciente: {$consulta['NombrePaciente']}, Sintomatología: {$consulta['ExtractoSintomatologia']}";
                    echo "<form method='get' action='consulta.php'>";
                    echo "<input type='hidden' name='id_consulta' value='{$consulta['id_consulta']}'>";
                    echo "<button type='submit'>Ir a Consulta</button>";
                    echo "</form></li>";
                }
                ?>
            </ul>
        </section>
    <?php else : ?>
        <p>Este médico no tiene consultas registradas.</p>
    <?php endif; ?>
<?php endif; ?>

</body>

</html>
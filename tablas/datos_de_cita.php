<?php
include("tablas/crea_tablas.php");
//conseguir id de paciente que inicia sesión
session_start();
$pacienteSelect=$_SESSION["idPaciente"];
//conseguir la fecha selecionado de la cita
if (isset($_POST["registro"]) && $_POST["cita"]) {
    # actualiza la fecha que este paciente ya elige en la tabla consulta
    $fecha=$_POST["cita"];
    $update="UPDATE consulta 
    SET fecha=$fecha
    WHERE id_paciente=$pacienteSelect";
    mysqli_query($conexion,$update);
}
//conseguir id de médico selecionado de la cita
if (isset($_POST["registro"]) && $_POST["medico"]) {
    # actualiza el id de médico que este paciente ya elige en la tabla consulta
    $idMedico=$_POST["medico"];
    $update="UPDATE consulta 
    SET id_medico=$idMedico
    WHERE id_paciente=$pacienteSelect";
    mysqli_query($conexion,$update);
    # actualiza el id de médico que este paciente ya elige en la tabla paciente
    $update="UPDATE  paciente
    SET id_med=$idMedico
    WHERE id=$pacienteSelect";
    mysqli_query($conexion,$update);
}
//conseguir la síntoma que este paciente ha apuntado
if (isset($_POST["registro"]) && $_POST["sintoma"]) {
    # actualiza la síntoma que este paciente ya elige en la tabla consulta
    $sintoma=$_POST["sintoma"];
    $update="UPDATE consulta 
    SET sintomatologia=$sintoma
    WHERE id_paciente=$pacienteSelect";
    mysqli_query($conexion,$update);
}   
?>

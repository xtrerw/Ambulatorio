<?php
    include("db/conecta.php");

    $conexion = getConexionsinBD();
    $sql="CREATE DATABASE ambulatorio";
    mysqli_query($conexion,$sql);
    $resulta=mysqli_query($conexion,"SHOW DATABASES LIKE 'ambulatorio'");
    if($resulta->num_rows>0){ //num_rows >0 existe
        mysqli_select_db($conexion, "ambulatorio");
    }else{
        $conexion=getConexion();
        mysqli_select_db($conexion, "ambulatorio");    
    }
    // crea tablas
    $medico="CREATE TABLE IF NOT EXISTS medico(
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(255),
        apellidos VARCHAR(255),
        especialidad VARCHAR(255)
    );";
    mysqli_query($conexion,$medico);
    $medicamento="CREATE TABLE IF NOT EXISTS medicamento(
        id INT AUTO_INCREMENT PRIMARY KEY,
        medicamento VARCHAR(255)
    );";
     mysqli_query($conexion,$medicamento);
    $pacientes="CREATE TABLE IF NOT EXISTS pacientes(
        id INT AUTO_INCREMENT PRIMARY KEY,
        id_med INT,
        dni VARCHAR(9),
        nombre VARCHAR(255),
        apellido VARCHAR(255),
        genero CHAR(1),
        fecha_nac DATE,
        FOREIGN KEY (id_med) REFERENCES medico(id)
    );";
    mysqli_query($conexion,$pacientes);
    $consulta="CREATE TABLE IF NOT EXISTS consulta (
        id INT AUTO_INCREMENT PRIMARY KEY,
        id_medico INT,
        id_paciente INT,
        fecha DATE,
        diagnostico VARCHAR(255),
        sintomatologia VARCHAR(255),
        FOREIGN KEY (id_medico) REFERENCES medico(id),
        FOREIGN KEY (id_paciente) REFERENCES pacientes(id)
        );";
    mysqli_query($conexion,$consulta);
        //
    $receta="CREATE TABLE IF NOT EXISTS receta (
        id_medicamento INT,
        id_consulta INT,
        posologia VARCHAR(255),
        fecha_fin DATE,
        FOREIGN KEY (id_medicamento) REFERENCES medicamento(id),
        FOREIGN KEY (id_consulta) REFERENCES consulta(id)
    );";
    mysqli_query($conexion,$receta);
    //inserta datos
    $medico="SELECT * FROM medico";
    $medicamento="SELECT * FROM medicamento";
    $pacientes="SELECT * FROM pacientes";
    $consulta="SELECT * FROM consulta";
    $receta="SELECT * FROM receta";
    
    $medico=mysqli_query($conexion,$medico);
    $medicamento=mysqli_query($conexion,$medicamento);
    $pacientes=mysqli_query($conexion,$pacientes);
    $consulta=mysqli_query($conexion,$consulta);
    $receta=mysqli_query($conexion,$receta);
    //inserta datos a la tabla médico
    if ($medico->num_rows==0){
        $inserta1="INSERT INTO medico(nombre,apellidos,especialidad) VALUES ('Daaa','Kami','FAMILIA');";
        $inserta2="INSERT INTO medico(nombre,apellidos,especialidad) VALUES ('Docker','Hambur','CABECERA');";
        $inserta3="INSERT INTO medico(nombre,apellidos,especialidad) VALUES ('Julia','Fish','CABECERA');";
        $inserta4="INSERT INTO medico(nombre,apellidos,especialidad) VALUES ('Oporto','Oua','FAMILIA');";
        mysqli_query($conexion,$inserta1);
        mysqli_query($conexion,$inserta2);
        mysqli_query($conexion,$inserta3);
        mysqli_query($conexion,$inserta4);
    }
    //inserta datos a la tabla medicamento
    if ($medicamento->num_rows==0){
        $inserta1="INSERT INTO medicamento(medicamento) VALUES ('Prozac');";
        $inserta2="INSERT INTO medicamento(medicamento) VALUES ('Poción de vida');";
        $inserta3="INSERT INTO medicamento(medicamento) VALUES ('Aspirina');";
        $inserta4="INSERT INTO medicamento(medicamento) VALUES ('Formalina');";
        mysqli_query($conexion,$inserta1);
        mysqli_query($conexion,$inserta2);
        mysqli_query($conexion,$inserta3);
        mysqli_query($conexion,$inserta4);
    }
    //inserta datos a la tabla paciente
    if ($pacientes->num_rows==0){
        $inserta1="INSERT INTO pacientes(dni,nombre,apellido,genero,fecha_nac,id_med) VALUES ('123456789','Loli','Smash','M','1999-10-03',1);";
        $inserta2="INSERT INTO pacientes(dni,nombre,apellido,genero,fecha_nac,id_med) VALUES ('y12345678','Lord','DASDSA','H','1900-01-02',3);";
        $inserta3="INSERT INTO pacientes(dni,nombre,apellido,genero,fecha_nac,id_med) VALUES ('ABCDEF123','Benk','WQDQD','M','1967-01-03',2);";
        $inserta4="INSERT INTO pacientes(dni,nombre,apellido,genero,fecha_nac,id_med) VALUES ('012345678','Oua','Fash','H','2000-05-23',4);";
        mysqli_query($conexion,$inserta1);
        mysqli_query($conexion,$inserta2);
        mysqli_query($conexion,$inserta3);
        mysqli_query($conexion,$inserta4);
    }
    //inserta datos a la tabla consulta
    if ($consulta->num_rows==0){
        $inserta1="INSERT INTO consulta(fecha,diagnostico,sintomatologia,id_medico,id_paciente) VALUES ('2023-12-01','Esquizofrenia','pensamiento desorganizado',1,1);";
        $inserta2="INSERT INTO consulta(fecha,diagnostico,sintomatologia,id_medico,id_paciente) VALUES ('2023-01-09','VIH','diarrea',3,2);";
        $inserta3="INSERT INTO consulta(fecha,diagnostico,sintomatologia,id_medico,id_paciente) VALUES ('2023-12-05','VIH','fiebre baja',2,3);";
        $inserta4="INSERT INTO consulta(fecha,diagnostico,sintomatologia,id_medico,id_paciente) VALUES ('2024-03-12','Cáncer de pulmón','dolor de pecho.',4,4);";
        mysqli_query($conexion,$inserta1);
        mysqli_query($conexion,$inserta2);
        mysqli_query($conexion,$inserta3);
        mysqli_query($conexion,$inserta4);
    }
    //inserta datos a la tabla receta
    if($receta->num_rows==0){
        $inserta1="INSERT INTO receta(id_medicamento,id_consulta,posologia,fecha_fin) VALUES (4,1,'2cap/mañ-2m','2024-04-13');";
        $inserta2="INSERT INTO receta(id_medicamento,id_consulta,posologia,fecha_fin) VALUES (3,2,'2cap/noc-5m','2024-05-13');";
        $inserta3="INSERT INTO receta(id_medicamento,id_consulta,posologia,fecha_fin) VALUES (2,3,'4cap/mañ-3m','2023-12-13');";
        $inserta4="INSERT INTO receta(id_medicamento,id_consulta,posologia,fecha_fin) VALUES (1,4,'3cap/mañ-10am','2024-06-13');";
        mysqli_query($conexion,$inserta1);
        mysqli_query($conexion,$inserta2);
        mysqli_query($conexion,$inserta3);
        mysqli_query($conexion,$inserta4);
    }
?>
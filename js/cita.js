function hoy() { 
    var fecha=new Date();
    var dia=fecha.getDate();
    var mes=fecha.getMonth();
    var year=fecha.getFullYear();
    dia= dia < 10 ? '0'+dia : dia;
    mes= mes < 10 ? '0'+mes : mes;
    document.getElementById("fecha").innerHTML=year+'-'+mes+'-'+dia;
}
setInterval(time,10);
time();
var cronica = document.getElementById('cronica');
var dia=document.getElementById('dia');
function check() {
    if (cronica.checked) {
        dia.style.display="none";
        dia.value=365;
    } else {
        dia.style.display="block";
    }
}
//
//la fecha seleccionada
window.onload = function () { 
    Calendar.setup({
        inputField:"cita",
        ifFormat:"%Y-%m-%d",
        button:"selector",
    });
}
//función para comprobar la fecha elegida si es válida. 
function fecha() { 
    //advertencia de html
    var adv=document.getElementById("advertencia");
    //bóton de pedir la cita
    var btnCita=document.getElementById("registro");
    //conseguir la fecha seleccionada
    var cita=document.getElementById("cita").value;
    var cita=new Date(cita);
    var citaDay=cita.getDay();
    //conseguir la fecha de hoy
    var hoy=new Date();
    var ano=hoy.getFullYear();
    var mes=hoy.getMonth();
    var dia=hoy.getDate();
    //si el mes o día es menor de octubre, tendrá la formara como 0 mas mes o día
    mes=mes<10? '0'+mes:mes;
    dia=dia<10? '0'+dia:dia;
    //lo deja como la forma de año-mes-día
    var hoyObj=ano+'-'+mes+'-'+dia;
    if (cita<hoy) {
    //si la fecha de cita es anterior al día de hoy, aparece "fecha no válida" en fuente rojo
        adv.innerHTML="fecha no válida : "+cita;
        adv.style.color="brown";
        adv.style.display="block";
        btnCita.style.display="none";
    } else if(citaDay==0 || citaDay==6){
        //si la fecha es el fin de semana, te advierte "elija un día laborable"
        adv.innerHTML="Por favor, elija un día laborable";
        adv.style.color="brown";
        adv.style.display="block";
        btnCita.style.display="none";
    } else if (cita > hoy.setMonth(hoy.getMonth()+3)) {
        //si le deja pedir otra vez una fecha como máximo 3 meses en el futuro.
        adv.innerHTML="Pide una fecha como máximo 3 meses en el futuro";
        adv.style.color="brown";
        adv.style.display="block";
        btnCita.style.display="none";
    } else {
        adv.style.display="none";
        btnCita.style.display="block";
    }
}
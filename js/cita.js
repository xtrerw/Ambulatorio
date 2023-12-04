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
    if (cita<hoy.setDate(hoy.getDate()-1)) {
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
    } else if (cita > hoy.setDate(hoy.getDate()+30)) {
        //si la fecha es más tarde de un mes de hoy, te deja pedir otra vez una fecha como máximo 30 días en el futuro.
        adv.innerHTML="Tan malo no estarás. Pide una fecha como máximo 30 días en el futuro";
        adv.style.color="brown";
        adv.style.display="block";
        btnCita.style.display="none";
    } else  {
        adv.style.display="none";
        btnCita.style.display="block";
    }
}
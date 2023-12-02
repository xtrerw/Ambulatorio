window.onload = function () { 
    Calendar.setup({
        inputField:"cita",
        ifFormat:"%Y-%m-%d",
        button:"selector",
    });
}

function fecha() { 
    var adv=document.getElementById("advertencia");
    var cita=document.getElementById("cita").value;

    var hoy=new Date();
    ano=hoy.getFullYear();
    mes=hoy.getMonth();
    dia=hoy.getDate();
    mes=mes<10? '0'+mes:mes;
    dia=dia<10? '0'+dia:dia;
    var hoyObj=ano+'-'+mes+'-'+dia;
    if (cita>hoyObj) {
        adv.innerHTML="fecha con válida : " +cita;
        adv.style.color="green";
        adv.style.display="block";
    } else {
        adv.innerHTML="fecha sin válida : "+cita;
        adv.style.color="brown";
        adv.style.display="block";
    }
}
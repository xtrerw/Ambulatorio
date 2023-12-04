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
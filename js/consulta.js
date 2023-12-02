var cronica = document.getElementById('cronica');
var dia=document.getElementById('dia');
function check() {
    if (cronica.checked) {
        dia.style.display="none";
    } else {
        dia.style.display="block";
    }
}
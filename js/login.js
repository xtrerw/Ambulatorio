//cuando toca uno de las paginas login, será más clara.
var form1=document.getElementById("form1");
var form2=document.getElementById("form2");

form1.addEventListener("mouseenter",function() {
    form2.className='enter';
  });
form1.addEventListener("mouseleave", function() {
    form2.className = "leave"; 
});
form2.addEventListener("mouseenter",function() {
    form1.className='enter';
  });
form2.addEventListener("mouseleave", function() {
    form1.className = "leave";
});
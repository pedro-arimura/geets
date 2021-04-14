// Fullscrene NAvigation
document.querySelector('.openNav').addEventListener("click",openNav);
function openNav() {
  document.getElementById("myNav").style.width = "100%";
}
document.querySelector('.closeNav').addEventListener("click",closeNav);
function closeNav() {
  document.getElementById("myNav").style.width = "0%";
}

// Accordion

var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    }
  });
}
document.querySelector('.accordion-1').addEventListener("click",function(){
  document.querySelector('.accordion-1 p').classList.toggle('bold');
});
document.querySelector('.accordion-2').addEventListener("click",function(){
  document.querySelector('.accordion-2 p').classList.toggle('bold');
});

document.querySelector('.accordion-3').addEventListener("click",function(){
  document.querySelector('.accordion-3 p').classList.toggle('bold');
});
document.querySelector('.accordion-4').addEventListener("click",function(){
  document.querySelector('.accordion-4 p').classList.toggle('bold');
});
document.querySelector('.accordion-5').addEventListener("click",function(){
  document.querySelector('.accordion-5 p').classList.toggle('bold');
});

// BAck to top

//Get the button
var mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction();};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.opacity = "1";
  } else {
    mybutton.style.opacity = "0";
  }
}
mybutton.addEventListener("click",topFunction);
// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}
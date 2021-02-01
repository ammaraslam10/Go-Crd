
function productopenmodal() {
  document.getElementById("productmodal").style.display = "block";
}

function productclosemodal() {
  document.getElementById("productmodal").style.display = "none";
}



var Indexslide = 1;
runSlides(Indexslide);

function nextSlides(a) {
  runSlides(Indexslide += a);
}

function productcurrentSlide(a) {
runSlides(Indexslide = a);

    
}

function runSlides(a) {
  var i;
  var slides = document.getElementsByClassName("mySlidesproducts");
  if (a > slides.length) {Indexslide = 1}
  if (a < 1) {Indexslide = slides.length}
 for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
 
  slides[Indexslide-1].style.display = "block";

}

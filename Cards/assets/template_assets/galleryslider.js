
function galleryopenmodal() {
  document.getElementById("gallerymodal").style.display = "block";
}

function galleryclosemodal() {
  document.getElementById("gallerymodal").style.display = "none";
}



var Indexslide = 1;
gallerySlide(Indexslide);

function nextslides(b) {
  gallerySlide(Indexslide += b);
}

function gallerycurrentslider(b) {
gallerySlide(Indexslide = b);

    
}

function gallerySlide(b) {
  var i;
  var slides = document.getElementsByClassName("galleryslide");
  if (b > slides.length) {Indexslide = 1}
  if (b < 1) {Indexslide = slides.length}
 for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
 
  slides[Indexslide-1].style.display = "block";

}

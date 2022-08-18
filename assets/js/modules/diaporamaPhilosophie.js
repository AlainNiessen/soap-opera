let diaporama = document.querySelector(".m-philosophie-diaporama");
let slides = document.querySelectorAll(".mySlides");
let btnNext = document.getElementById("next");
let btnPrev = document.getElementById("prev");
let dots = document.querySelectorAll('.dot');
let n;

if(diaporama) {
    
    let slideIndex = 1;
    showSlides(slideIndex);

    // eventListener sur les différents éléments
    btnPrev.addEventListener('click', () => {
        plusSlides(-1);
    });
    btnNext.addEventListener('click', () => {
        plusSlides(1);
    });

    dots.forEach(function (dot, i) {
        dot.addEventListener('click', () => {
            currentSlide(i+1);
        });
    });
    
    function plusSlides(n) {
        showSlides(slideIndex += n);
    }


    function currentSlide(n) {
        showSlides(n);
    }

    function showSlides(n) {
        let i;
        
        if (n > slides.length) {
            slideIndex = 1;
        }

        if (n < 1) {
            slideIndex = slides.length;
        }

        for (i = 0; i < slides.length; i++) {
            slides[i].className = slides[i].className.replace(" show", "");
        }

        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }

        slides[slideIndex-1].className += " show";
        dots[slideIndex-1].className += " active";
    }
}
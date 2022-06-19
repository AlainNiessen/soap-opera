// ----------------------------
// Animation NAVBAR
// ----------------------------

let hamburger = document.getElementById('l-topbar-hamburger');
let menu = document.getElementById('l-topbar-navbar');

hamburger.addEventListener('click', () => {
    hamburger.classList.toggle('active');
    menu.classList.toggle('active');
})

// ----------------------------
// Animation Barre de recherche 
// ----------------------------

let barreForm = document.getElementById('m-recherche-barre-form');
let input = document.getElementById('mots');
let button = document.getElementById('submit-rech-btn');

input.addEventListener('click', (e) => {
    e.currentTarget.style.outline = "none";

    // au-dessous de 576px => 10rem à 240px (15rem)
    if (window.matchMedia('(max-width: 576px)').matches) {  
        e.currentTarget.style.width = '240px';
        e.currentTarget.style.transition = 'width 1s ease-in';
    // au-dessus de 576px => 15rem à 400px (25rem)
    } else {
        e.currentTarget.style.width = '400px';
        e.currentTarget.style.transition = 'width 1s ease-in';
    }
});

// ----------------------------
// Animation ONGLET DETAIL ARTICLE
// ----------------------------

//récupération des tous les onglets et contenus
const onglets = document.querySelectorAll('.onglets');
const contenu = document.querySelectorAll('.contenu');
//définition index
let index = 0;

//boucle sur les éléments
onglets.forEach(onglet => {
    //ajout à chaque élément un eventListener click
    onglet.addEventListener('click', () => {
        //si élément contient la class "act", rien se passe, sinon elle recoit la class "act"
        if(onglet.classList.contains('act')) {
            return;
        } else {
            onglet.classList.add('act');
        }

        //récupération de data-anim
        index = onglet.getAttribute('data-anim');
        
        //boucle pour enlever la class "act" aux éléments sur lesquells on n'a pas clické
        for(i = 0; i < onglets.length; i++) {

            //si le data_anim ne correspond pas à index du onglet actuell => remove de la class "active"
            if(onglets[i].getAttribute('data-anim') != index) {
                onglets[i].classList.remove('act');
            }

        }

        //boucle pour afficher le bon contenu correspondant à l'onglet
        for(j = 0; j < contenu.length; j++) {

            //si le data-anim est strictement égal à l'index de l'onglet => on ajoute la classe "activeContenu", sinon remove de la class
            if(contenu[j].getAttribute('data-anim') === index) {
                contenu[j].classList.add('activeContenu');
            } else {
                contenu[j].classList.remove('activeContenu');
            }
        }
    })    
})

// ----------------------------
    // Animation formulaire commentaire pop-up
    // ---------------------------- 

    //récupération des tous les onglets et contenus
    const btn_form_commentaire = document.getElementById('submit-commentaire');
    const formulaire_commentaire = document.getElementById('commentaire');
    const croix_commentaire = document.getElementById('back_to_page');
    
    //event pour afficher le formulaire
    btn_form_commentaire.addEventListener('click', () => {
        formulaire_commentaire.classList.add('show');
       
    })
    
    //event pour cacher le formulaire
    croix_commentaire.addEventListener('click', () => {
        formulaire_commentaire.classList.remove('show');
        
    })


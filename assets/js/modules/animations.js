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
        //si élément contient la class "active", rien se passe, sinon elle recoit la class "active"
        if(onglet.classList.contains('act')) {
            return;
        } else {
            onglet.classList.add('act');
        }

        //récupération de data-anim
        index = onglet.getAttribute('data-anim');
        
        //boucle pour enlever la class "active" aux éléments sur lesquells on n'a pas clické
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


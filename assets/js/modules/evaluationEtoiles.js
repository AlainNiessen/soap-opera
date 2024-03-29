// ----------------------------
// EVALUATION ETOILES
// ----------------------------

// récupération de toutes les étoiles    
const etoiles = document.querySelectorAll('.la-star');

//vérification si les étoiles sont bien présentes sur la page détail de l'article
// => 1 formulaire avec un input hidden avec id note
if(etoiles && window.location.href.includes('detail')) {
    // récupération de l'input hidden
    const note = document.getElementById('note');
    
    // boucle sur les étoiles pour ajouter un EventListener
    for(etoile of etoiles) {
        //EventListener click sur les étoiles
        etoile.addEventListener('click', function() {
            // cette fonction remet toutes les étoiles dans la couleur noir 
            // exemple: on passe de 5 étoiles à 3
            resetEtoiles();
            this.style.color = "#ffcf76";

            //récupération de l'éléments précédent dans le DOM (de même niveau, balise soeur)
            let etoilePrecedente = this.previousElementSibling;

            // tant qu'il y a des étoiles précédentes =>
            while(etoilePrecedente) {
                // changement de couleur
                etoilePrecedente.style.color = "#ffcf76";
                // récupération de l'étoile précédente
                etoilePrecedente = etoilePrecedente.previousElementSibling;

            }

            //actualisation du nombre dans le input hidden (sur base de data-value de l'étoile)
            note.value = this.dataset.value;
        })
    }
//vérification si les étoiles sont bien présentes sur la page profile d'utilisatueur
// => Plusieurs formulaire avec un input hidden différents ID's
} else if (etoiles && window.location.href.includes('profile')) {
        
    // boucle sur les étoiles pour ajouter un EventListener
    for(etoile of etoiles) {
        //EventListener click sur les étoiles
        etoile.addEventListener('click', function() {
            // récupération du input hidden du formulaire en question
            let inputHiddenId = this.parentElement.nextElementSibling.firstElementChild.id;
            let note = document.getElementById(inputHiddenId);
                       
            // cette fonction remet toutes les étoiles dans la couleur noir 
            // exemple: on passe de 5 étoiles à 3
            resetEtoiles();
            this.style.color = "#ffcf76";

            //récupération de l'éléments précédent dans le DOM (de même niveau, balise soeur)
            let etoilePrecedente = this.previousElementSibling;

            // tant qu'il y a des étoiles précédentes =>
            while(etoilePrecedente) {
                // changement de couleur
                etoilePrecedente.style.color = "#ffcf76";
                // récupération de l'étoile précédente
                etoilePrecedente = etoilePrecedente.previousElementSibling;

            }

            //actualisation du nombre dans le input hidden (sur base de data-value de l'étoile) dans le formulaire correspondant
            note.value = this.dataset.value;
        })
    }
}

function resetEtoiles() {
    for(etoile of etoiles) {
        etoile.style.color = "#575757";
    }
}
    

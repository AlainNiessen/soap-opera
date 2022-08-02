
// récupération de toutes les étoiles    
const etoiles = document.querySelectorAll('.la-star');
//vérification si les étoiles sont bien présentes sur la page actuelle
if(etoiles) {
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
} 

function resetEtoiles() {
    for(etoile of etoiles) {
        etoile.style.color = "#575757";
    }
}
    

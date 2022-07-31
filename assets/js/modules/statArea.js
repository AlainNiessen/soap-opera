// chargement DOM pour pouvoir accéder à tous les éléments nécessaires
window.onload = () => {  
    // définition variables
    let btnStats = document.getElementById('btn-stats');
    let adminArea = document.getElementById('m-admin');
    let url;

    // si on est sur la page d'accueil de l'interface admin
    if(adminArea && btnStats) {
        btnStats.addEventListener('click', function() {
            url = window.location.href;
            affichageStatistique(url);   
        })
             
    }

    //fonction ajax fetch
    async function affichageStatistique(url) {
        //traitement AJAX
        
        //await => on va attendre le résultat du fetch
        const response = await fetch(url, {
            // entête pour expliquer au backend qu'on fait un appel en ajax
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        console.log(response);
        //si la réponse est bonne
        if(response.status >= 200 && response.status < 300) {
            // on récupére la réponse en format json
            const data = await response.json();
           
            console.log(data);
        } 
    }
}

import Chart from 'chart.js/auto';

// chargement DOM pour pouvoir accéder à tous les éléments nécessaires
window.onload = () => {  
    // définition variables
    let btnStats = document.getElementById('btn-stats');
    let adminArea = document.getElementById('m-admin');   
    let url = window.location.href;
    

    // si on est sur la page d'accueil de l'interface admin
    if(adminArea && btnStats) {
        //remettre le wrapper sur max-width 100% pour que l'interface admin est sur 100% de l'écran
        document.querySelector('.wrapper').style.maxWidth = '100%';
        // event sur le bouton
        btnStats.addEventListener('click', function() {            
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
        
        //si la réponse est bonne
        if(response.status >= 200 && response.status < 300) {
            // on récupére la réponse en format json
            const data = await response.json();           
           
            buildStatistiques(data);
        } 
    }

    function buildStatistiques(data)
    {
        let titleStatCatNews = '';
        let titleGeneral = '';
        let titleNombUtilisateur = '';
        let titleNombArticles = '';
        // récupération de la langue
        if(data.langue == "de") {            
            titleStatCatNews = 'Anzahl Nutzer des verschiedenen KAtegorien der Newsletter';
            titleGeneral = "Allgemeines";
            titleNombUtilisateur = 'Anzahl eingeschriebener Nutzer';
            titleNombArticles = 'Anzahl Artikel';
        } else if(data.langue == "fr") {
            titleStatCatNews = 'Nombre d\'utilisateurs des différentes catégories de la newsletter';
            titleGeneral = "Général";
            titleNombUtilisateur = 'Nombre d\'utilisateurs enregistrés';
            titleNombArticles = 'Nombre d\'articles';
        } else if(data.langue == "en") {
            titleStatCatNews = 'Number of users of the different categories of the newsletter';
            titleGeneral = "General";
            titleNombUtilisateur = 'Number of registered users';
            titleNombArticles = 'Number of articles';
        }
        
        // build des statistiques générales
        let titreGeneral = document.getElementById('titreGeneral');
        titreGeneral.textContent = titleGeneral;

        let titreNombUtilisteur = document.getElementById('titreNombreUtilisateur');
        titreNombUtilisteur.textContent = data.nombreUtilisateurs;
        let titreNombUtilisteurText = document.getElementById('titreNombreUtilisateurText');
        titreNombUtilisteurText.textContent = titleNombUtilisateur;

        let titreNombArticles = document.getElementById('titreNombreArticles');
        titreNombArticles.textContent = data.nombreArticles;
        let titreNombArticlesText = document.getElementById('titreNombreArticlesText');
        titreNombArticlesText.textContent = titleNombArticles;

        // build statistique nombre des utilisteurs par catégorie de newsletter
        let canvasCatNews = document.getElementById('nombre-utilisateurs-cat-news');
        let titreStatCatNews = document.getElementById('titreStatCatNews');
        titreStatCatNews.textContent = titleStatCatNews;
        let statCatNews = new Chart(canvasCatNews, {
            type: "pie",
            data: {
                labels: data.nomsCategoriesNewsletter,
                datasets: [{
                    data: data.nombreUtilisateursCategorieNewsletter,
                    backgroundColor: data.couleurCategorieNewsletter
                }]
            }
        })
    }
}

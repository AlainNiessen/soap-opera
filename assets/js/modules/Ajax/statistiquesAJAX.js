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
        let titleNombUtilisateur = '';
        let titleNombArticles = '';
        let titleNombArticlesVendus = '';
        let titleNombFactures = '';
        let titleNombVentesParCategorie = '';
        // récupération de la langue
        if(data.langue == "de") {            
            titleStatCatNews = 'Anzahl Nutzer der verschiedenen Kategorien der Newsletter';
            titleNombUtilisateur = 'Anzahl eingeschriebener Nutzer';
            titleNombArticles = 'Anzahl Artikel';
            titleNombArticlesVendus = 'Anzahl Verkäufe';
            titleNombFactures = 'Anzahl Rechnungen';
            titleNombVentesParCategorie = 'Anzahl Verkäufe pro Artikelkategorie';
        } else if(data.langue == "fr") {
            titleStatCatNews = 'Nombre d\'utilisateurs des différentes catégories de la newsletter';
            titleNombUtilisateur = 'Nombre d\'utilisateurs enregistrés';
            titleNombArticles = 'Nombre d\'articles';
            titleNombArticlesVendus = 'Nombre de ventes';
            titleNombFactures = 'Nombre de factures';
            titleNombVentesParCategorie = 'Nombre de ventes par catégorie d\'article';
        } else if(data.langue == "en") {
            titleStatCatNews = 'Number of users of the different categories of the newsletter';
            titleNombUtilisateur = 'Number of registered users';
            titleNombArticles = 'Number of articles';
            titleNombArticlesVendus = 'Number of sells';
            titleNombVentesParCategorie = 'Number of sales per article category';
        }
        
        // build des statistiques générales
        let infobox1 = document.getElementById('box-1');
        let infobox2 = document.getElementById('box-2');
        let infobox3 = document.getElementById('box-3');
        let infobox4 = document.getElementById('box-4');

        infobox1.style.backgroundColor = "#a7dae6";
        infobox2.style.backgroundColor = "#ffcf76";
        infobox3.style.backgroundColor = "#80e485";
        infobox4.style.backgroundColor = "#c8f58c";

        let titreNombUtilisteur = document.getElementById('titreNombreUtilisateur');
        titreNombUtilisteur.textContent = data.nombreUtilisateurs;
        let titreNombUtilisteurText = document.getElementById('titreNombreUtilisateurText');
        titreNombUtilisteurText.textContent = titleNombUtilisateur;

        let titreNombArticles = document.getElementById('titreNombreArticles');
        titreNombArticles.textContent = data.nombreArticles;
        let titreNombArticlesText = document.getElementById('titreNombreArticlesText');
        titreNombArticlesText.textContent = titleNombArticles;

        let titreNombArticlesVendus = document.getElementById('titreNombreArticlesVendus');
        titreNombArticlesVendus.textContent = data.nombreArticlesVendus;
        let titreNombArticlesTextVendus = document.getElementById('titreNombreArticlesTextVendus');
        titreNombArticlesTextVendus.textContent = titleNombArticlesVendus;

        let titreNombFactures = document.getElementById('titreNombreFactures');
        titreNombFactures.textContent = data.nombreFactures;
        let titreNombFacturesText = document.getElementById('titreNombreFacturesText');
        titreNombFacturesText.textContent = titleNombFactures;

        // build statistique nombre des utilisteurs par catégorie de newsletter
        let canvasCatNews = document.getElementById('nombreUtilisateursCatNews');
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
            },
            options: {  
                maintainAspectRatio: false
            }
        })

        // build statistique nombre des utilisteurs par catégorie de newsletter
        let canvasVentesParCategorie = document.getElementById('nombreVentesParCategorie');
        let titreStatVentesParCategorie = document.getElementById('titreStatVentesParCategorie');

        titreStatVentesParCategorie.textContent = titleNombVentesParCategorie;
        let statVentesParcategorie = new Chart(canvasVentesParCategorie, {
            type: "bar",
            data: {
                labels: data.nomsCategoriesArticle,
                datasets: [{
                    data: data.nombreVentesParCategorie,
                    backgroundColor: data.couleurCategorieArticle
                }]
            },
            options: {  
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        })
    }
}

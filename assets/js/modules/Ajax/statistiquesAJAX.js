//----------------------------------------------
// GESTION DE STATISTIQUES
//----------------------------------------------

// import chart
import Chart from 'chart.js/auto';

// chargement DOM pour pouvoir accéder à tous les éléments nécessaires
window.onload = () => {  
    // définition variables
    let btnStats = document.getElementById('btn-stats');
    let adminArea = document.getElementById('m-admin'); 
    let btnContainer = document.querySelector('.m-admin-stat-intro'); 
    let url = window.location.href;    

    // si on est sur la page d'accueil de l'interface admin
    if(adminArea && btnStats) {
        //remettre le wrapper sur max-width 100% pour que l'interface admin est sur 100% de l'écran
        document.querySelector('.wrapper').style.maxWidth = '100%';
        // event sur le bouton
        btnContainer.addEventListener('click', (e) => {
            if(e.target.id == "btn-stats") {
                affichageStatistique(url);  
            }
             
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
        let titleBestseller = "";
        // récupération de la langue
        if(data.langue == "de") {            
            titleStatCatNews = 'Anzahl Nutzer der verschiedenen Kategorien der Newsletter';
            titleNombUtilisateur = 'Anzahl eingeschriebener Nutzer';
            titleNombArticles = 'Anzahl Artikel';
            titleNombArticlesVendus = 'Anzahl Verkäufe';
            titleNombFactures = 'Anzahl Rechnungen';
            titleNombVentesParCategorie = 'Anzahl Verkäufe pro Artikelkategorie';
            titleBestseller = 'Bestseller pro Kategorie';
        } else if(data.langue == "fr") {
            titleStatCatNews = 'Nombre d\'utilisateurs des différentes catégories de la newsletter';
            titleNombUtilisateur = 'Nombre d\'utilisateurs enregistrés';
            titleNombArticles = 'Nombre d\'articles';
            titleNombArticlesVendus = 'Nombre de ventes';
            titleNombFactures = 'Nombre de factures';
            titleNombVentesParCategorie = 'Nombre de ventes par catégorie d\'article';
            titleBestseller = 'Bestseller par catégorie';
        } else if(data.langue == "en") {
            titleStatCatNews = 'Number of users of the different categories of the newsletter';
            titleNombUtilisateur = 'Number of registered users';
            titleNombArticles = 'Number of articles';
            titleNombArticlesVendus = 'Number of sells';
            titleNombVentesParCategorie = 'Number of sales per article category';
            titleBestseller = 'Bestseller of categories';
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
        // ckeck statut of chart
        let chart1Status = Chart.getChart('nombreUtilisateursCatNews'); // <canvas> id
        // si le statut est undefined => il n'existe pas
        // si le statut n'est pas undefined => il existe déjà et va être détruit pour que la requete AJAX peut reconstruire un nouveau CHART
        if (chart1Status != undefined) {
        chart1Status.destroy();
        }
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
        // ckeck statut of chart
        let chart2Status = Chart.getChart('nombreVentesParCategorie'); // <canvas> id
        // si le statut est undefined => il n'existe pas
        // si le statut n'est pas undefined => il existe déjà et va être détruit pour que la requete AJAX peut reconstruire un nouveau CHART
        if (chart2Status != undefined) {
        chart2Status.destroy();
        }
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

        let chartBest = [];
        let canvasBest = [];
        let titreBest = [];
        let statBest = [];

        let titreBestsellerText = document.getElementById('titreBestseller');
        titreBestsellerText.textContent = titleBestseller;

        for(let i = 0; i < data.bestseller.length; i++) {
        // ckeck statut of chart
        chartBest[i+1] = Chart.getChart('bestsellerCat'+ (i+1)); // <canvas> id
        // si le statut est undefined => il n'existe pas
        // si le statut n'est pas undefined => il existe déjà et va être détruit pour que la requete AJAX peut reconstruire un nouveau CHART
        if (chartBest[i+1] != undefined) {
        chartBest[i+1].destroy();
        }

        canvasBest[i+1] = document.getElementById('bestsellerCat' + (i+1));
        titreBest[i+1] = document.getElementById('titreCat' + (i+1));        

        titreBest[i+1].textContent = data.nomsCategoriesArticle[i];
        statBest[i+1] = new Chart(canvasBest[i+1], {
            type: "bar",
            data: {
                labels: data.bestseller[i][0],
                datasets: [{
                    data: data.bestseller[i][1],
                    backgroundColor: data.couleurCategorieArticle[i]
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

        // // build statistique Bestseller par catégorie

        // // ckeck statut of chart
        // let chartBest1 = Chart.getChart('bestsellerCat1'); // <canvas> id
        // // si le statut est undefined => il n'existe pas
        // // si le statut n'est pas undefined => il existe déjà et va être détruit pour que la requete AJAX peut reconstruire un nouveau CHART
        // if (chartBest1 != undefined) {
        // chartBest1.destroy();
        // }
        // let canvasBest1 = document.getElementById('bestsellerCat1');
        // let titreBest1 = document.getElementById('titreCat1');

        

        // titreBest1.textContent = data.nomsCategoriesArticle[0];
        // let statBest1 = new Chart(canvasBest1, {
        //     type: "bar",
        //     data: {
        //         labels: data.bestseller[0][0],
        //         datasets: [{
        //             data: data.bestseller[0][1],
        //             //backgroundColor: data.couleurCategorieArticle
        //         }]
        //     },
        //     options: {  
        //         maintainAspectRatio: false,
        //         plugins: {
        //             legend: {
        //                 display: false
        //             }
        //         }
        //     }
        // })
       
        // // ckeck statut of chart
        // let chartBest2 = Chart.getChart('bestsellerCat2'); // <canvas> id
        // // si le statut est undefined => il n'existe pas
        // // si le statut n'est pas undefined => il existe déjà et va être détruit pour que la requete AJAX peut reconstruire un nouveau CHART
        // if (chartBest2 != undefined) {
        // chartBest2.destroy();
        // }
        // let canvasBest2 = document.getElementById('bestsellerCat2');
        // let titreBest2 = document.getElementById('titreCat2');

        

        // titreBest2.textContent = data.nomsCategoriesArticle[1];
        // let statBest2 = new Chart(canvasBest2, {
        //     type: "bar",
        //     data: {
        //         labels: data.bestseller[1][0],
        //         datasets: [{
        //             data: data.bestseller[1][1],
        //             //backgroundColor: data.couleurCategorieArticle
        //         }]
        //     },
        //     options: {  
        //         maintainAspectRatio: false,
        //         plugins: {
        //             legend: {
        //                 display: false
        //             }
        //         }
        //     }
        // })
     
        // // ckeck statut of chart
        // let chartBest3 = Chart.getChart('bestsellerCat3'); // <canvas> id
        // // si le statut est undefined => il n'existe pas
        // // si le statut n'est pas undefined => il existe déjà et va être détruit pour que la requete AJAX peut reconstruire un nouveau CHART
        // if (chartBest3 != undefined) {
        // chartBest3.destroy();
        // }
        // let canvasBest3 = document.getElementById('bestsellerCat3');
        // let titreBest3 = document.getElementById('titreCat3');

        

        // titreBest3.textContent = data.nomsCategoriesArticle[2];
        // let statBest3 = new Chart(canvasBest3, {
        //     type: "bar",
        //     data: {
        //         labels: data.bestseller[2][0],
        //         datasets: [{
        //             data: data.bestseller[2][1],
        //             //backgroundColor: data.couleurCategorieArticle
        //         }]
        //     },
        //     options: {  
        //         maintainAspectRatio: false,
        //         plugins: {
        //             legend: {
        //                 display: false
        //             }
        //         }
        //     }
        // })

        // // ckeck statut of chart
        // let chartBest4 = Chart.getChart('bestsellerCat4'); // <canvas> id
        // // si le statut est undefined => il n'existe pas
        // // si le statut n'est pas undefined => il existe déjà et va être détruit pour que la requete AJAX peut reconstruire un nouveau CHART
        // if (chartBest4 != undefined) {
        // chartBest4.destroy();
        // }
        // let canvasBest4 = document.getElementById('bestsellerCat4');
        // let titreBest4 = document.getElementById('titreCat4');

        

        // titreBest4.textContent = data.nomsCategoriesArticle[3];
        // let statBest4 = new Chart(canvasBest4, {
        //     type: "bar",
        //     data: {
        //         labels: data.bestseller[3][0],
        //         datasets: [{
        //             data: data.bestseller[3][1],
        //             //backgroundColor: data.couleurCategorieArticle
        //         }]
        //     },
        //     options: {  
        //         maintainAspectRatio: false,
        //         plugins: {
        //             legend: {
        //                 display: false
        //             }
        //         }
        //     }
        // })

        // // ckeck statut of chart
        // let chartBest5 = Chart.getChart('bestsellerCat5'); // <canvas> id
        // // si le statut est undefined => il n'existe pas
        // // si le statut n'est pas undefined => il existe déjà et va être détruit pour que la requete AJAX peut reconstruire un nouveau CHART
        // if (chartBest5 != undefined) {
        // chartBest5.destroy();
        // }
        // let canvasBest5 = document.getElementById('bestsellerCat5');
        // let titreBest5 = document.getElementById('titreCat5');

        

        // titreBest5.textContent = data.nomsCategoriesArticle[4];
        // let statBest5 = new Chart(canvasBest5, {
        //     type: "bar",
        //     data: {
        //         labels: data.bestseller[4][0],
        //         datasets: [{
        //             data: data.bestseller[4][1],
        //             //backgroundColor: data.couleurCategorieArticle
        //         }]
        //     },
        //     options: {  
        //         maintainAspectRatio: false,
        //         plugins: {
        //             legend: {
        //                 display: false
        //             }
        //         }
        //     }
        // })

        // // ckeck statut of chart
        // let chartBest6 = Chart.getChart('bestsellerCat6'); // <canvas> id
        // // si le statut est undefined => il n'existe pas
        // // si le statut n'est pas undefined => il existe déjà et va être détruit pour que la requete AJAX peut reconstruire un nouveau CHART
        // if (chartBest6 != undefined) {
        // chartBest6.destroy();
        // }
        // let canvasBest6 = document.getElementById('bestsellerCat6');
        // let titreBest6 = document.getElementById('titreCat6');

        

        // titreBest5.textContent = data.nomsCategoriesArticle[5];
        // let statBest6 = new Chart(canvasBest6, {
        //     type: "bar",
        //     data: {
        //         labels: data.bestseller[5][0],
        //         datasets: [{
        //             data: data.bestseller[5][1],
        //             //backgroundColor: data.couleurCategorieArticle
        //         }]
        //     },
        //     options: {  
        //         maintainAspectRatio: false,
        //         plugins: {
        //             legend: {
        //                 display: false
        //             }
        //         }
        //     }
        // })
        
        

    }
}

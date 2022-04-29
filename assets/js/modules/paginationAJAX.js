//récupération des éléments
let contentList = document.getElementById('js-list-content');
let navigationBar = document.getElementById('js-list-bar-navigation');
let navigationCat = document.getElementById('js-list-cat-navigation');

//définition variables pour garder les paramétres passés par URL et par la method GET
let currentURL = window.location.href;
let param;

//si la pagination pour les résultats de la barre de recherche est existant
if(navigationBar) {
    navigationBar.addEventListener('click', (e) => { 
        e.preventDefault(); 
        // quand on clique à l'intérieur du élément navigationBar sur un élément qui contient la classe 'page-link' =>
        // on clique alors sur un lien de pagination (systéme de bubbling)
        if(e.target.classList.contains('page-link')) { 
            //on récupére les paramétres passés dans URL               
            if(currentURL.includes('mots')) {
                param = splitUrl(currentURL);
            };
            // on re-construit URL avec les paramétres pour les pages suivants
            let url = e.target.getAttribute('href') + '?' + param;
            //on appele la fonction ajax
            loadURL(url)       
        }
    })
}

// idem comme navigationCat, sauf qu'il n'y a pas des paramétres passés dans URL (URL est fix défini par la route)
if(navigationCat) {
    navigationCat.addEventListener('click', (e) => { 
        e.preventDefault();   
        if(e.target.classList.contains('page-link')) {             
            let url = e.target.getAttribute('href');
            loadURL(url)       
        }
    })
}



//fonction ajax fetch
async function loadURL(url) {
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
        //actualisation du contenu de la liste et de la pagination
        contentList.innerHTML = data.content;
        //si URL contient le mot categorie => alors on actualise la pagination dans la liste des articles avec une catégorie choisi
        // sinon on actualis la pagination pour les resultats de la recherche via la barre de recherche
        if(url.includes('categorie')) {
            navigationCat.innerHTML = data.navigationCat;
        } else {
            navigationBar.innerHTML = data.navigationBar;
        }        
        //actualisation URL
        history.replaceState({}, "", url);        
    }
}

function splitUrl(url) {
   
    let urlParts = url.split('?');
    let parameters = urlParts[1];

    return parameters;
}


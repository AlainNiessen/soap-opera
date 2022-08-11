//récupération des éléments
let contentList = document.getElementById('js-list-content');
let navigationBar = document.getElementById('js-list-bar-navigation');
let navigationCat = document.getElementById('js-list-cat-navigation');
let navigationPromo = document.getElementById('js-list-promo-navigation');
let navigationItems = document.querySelectorAll('.page-item');
let navigationLinks = document.querySelectorAll('.page-link');
let body = document.querySelector('body');

//définition variables pour garder les paramétres passés par URL et par la method GET
let currentURL = window.location.href;
let param;

// check quelle barre de pagination est active
if(navigationBar) {
    navigationBar.addEventListener('click', (e) => { 
        e.preventDefault(); 
        // quand on clique à l'intérieur du élément navigationBar sur un élément qui contient la classe 'page-link' =>
        // on clique alors sur un lien de pagination (systéme de bubbling)
        if(e.target.classList.contains('page-link')) { 
            //changement de la class 'active'
            navigationItems.forEach(item => {
                if(item.classList.contains('active')) {
                    item.classList.remove('active');
                }               
            });
            e.target.parentElement.classList.add('active'); 

            //on récupére les paramétres passés dans URL                         
            if(currentURL.includes('mots')) {
                param = splitUrl(currentURL);
            };
            // on re-construit URL avec les paramétres pour les pages suivants
            let url = e.target.getAttribute('href') + '?' + param;
            
            //on appele la fonction ajax
            loadURL(url);                  
        }
        // fonction qui scroll avec un setTimeout vers le top du body
        scrollToListTop(body);            
    })
} else if(navigationCat) {
    navigationCat.addEventListener('click', (e) => { 
        e.preventDefault();  
        
        if(e.target.classList.contains('page-link')) {
            //changement de la class 'active'
            navigationItems.forEach(item => {
                if(item.classList.contains('active')) {
                    item.classList.remove('active');
                }               
            });
            e.target.parentElement.classList.add('active'); 
                                             
            let url = e.target.getAttribute('href');
            loadURL(url)       
        }

        scrollToListTop(body);        
    })
} else if(navigationPromo) {
    navigationPromo.addEventListener('click', (e) => { 
        e.preventDefault();   
        
        if(e.target.classList.contains('page-link')) {
            //changement de la class 'active'
            navigationItems.forEach(item => {
                if(item.classList.contains('active')) {
                    item.classList.remove('active');
                }               
            });
            e.target.parentElement.classList.add('active'); 
                                  
            let url = e.target.getAttribute('href');
            loadURL(url)       
        }

        scrollToListTop(body);     
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
        } else if (url.includes('promotions')) {
            navigationPromo.innerHTML = data.navigationPromo;
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

function scrollToListTop(element) {
    // pendant que le contenu rafraichit, il y a un scroll automatique vers le haut de la page
    // sinon on reste sur la pagination et on doit scroller à chaque fois vers le haut manuellement
    setTimeout(function() {
        element.scrollIntoView({
            behavior: "smooth"
        });
    }, 1500);
}


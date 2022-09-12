//----------------------------------------------
// GESTION DE PANIER
//----------------------------------------------

changeQuantite();

//fonction ajax fetch
async function changeQuantiteArticlePanier(url) {
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
        
        // récupération des éléments et actualisation du contenu
        let htmlContent = document.querySelector('html');
        htmlContent.innerHTML = data.content;
        
        changeQuantite();
    }
}

function changeQuantite() {
    let tdBoutonsPlus = document.querySelectorAll('.articleplus');
    let tdBoutonsMinus = document.querySelectorAll('.articleminus');   

    if(tdBoutonsPlus) {
        for(tdBoutonPlus of tdBoutonsPlus) {
            tdBoutonPlus.addEventListener('click', (e) => {
                e.preventDefault(); 
                let url = e.currentTarget.getAttribute('href');
                changeQuantiteArticlePanier(url);                                                      
            })
        }            
    } 
    
    if (tdBoutonsMinus) {
        for(tdBoutonMinus of tdBoutonsMinus) {
            tdBoutonMinus.addEventListener('click', (e) => {
                e.preventDefault(); 
                let url = e.currentTarget.getAttribute('href');
                changeQuantiteArticlePanier(url);                                                       
            })
        }  
    }    
}

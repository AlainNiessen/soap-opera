//si la carte est présent dans le DOM
let maps = document.querySelectorAll('.map');

if(maps) {
    maps.forEach(mapPoint => {
        //recupération latitude et longitude
        let long = mapPoint.dataset.long;
        let lat = mapPoint.dataset.lat;
        let id = mapPoint.id;
        let element = document.getElementById(id);

        //on initialise la carte
        let map = L.map(element).setView([long, lat], 15);

        //on charge les "tuiles"
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: 'pk.eyJ1IjoiYWxhaW4xOTc5IiwiYSI6ImNsMDU3ejZvejBvc3kzZHBkd2trODl5d24ifQ.ewy0L_R1PnylQtpX21Su3w'
        }).addTo(map);

        //création marqeur + attribution d'un Popup
        let marqeur = L.marker([long, lat]).addTo(map);

        marqeur.bindPopup("<p>Hello</p>");

    })
   
}




    
    

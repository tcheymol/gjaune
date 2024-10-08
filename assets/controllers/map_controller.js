import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static values = {
        collectives: Array
    }

    connect() {
        this.initMap();
    }

    initMap() {
        const map = L.map('map').setView([46.966409, 2.483529], 5);
        L.tileLayer('https://tiles.stadiamaps.com/tiles/stamen_toner/{z}/{x}/{y}{r}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
        const greenIcon = L.icon({
            iconUrl: 'rp1.png',
            // shadowUrl: 'leaf-shadow.png',
            iconSize:     [35, 35], // size of the icon
        });

        this.collectivesValue.forEach(collective => {
            L.marker([collective.lat, collective.lon], {icon: greenIcon}).addTo(map);
        });
    }
}

export default class DpiMapsClient {
    constructor(selector, settings) {
        
        this.root = document.querySelector(selector);
        this.settings = JSON.parse(settings);
        
        if (!this.root) {
            console.error(`DPI_Maps: Unable to query element with selector ${selector}!`);
            return false;
        }
        
        if (!settings) {
            this.renderError();
            console.error('DPI Maps: Unable to load settings!');
            return false;
        }
        
        this.scaffoldServices();
        this.injectGoogleMaps();
    }
    
    renderError() {
        this.root.classList.add('dpi-maps-error');
        this.root.innerHTML = '<p>Unable to load google maps. Please try again later.</p>';
    }
    
    scaffoldServices() {
        window.initGoogleMap = () => {
            window.gmap = new window.google.maps.Map(this.root, {
                zoom: parseInt(this.settings.zoom) || 14,
                center: {lat: parseFloat(this.settings.center_latitude) || 42.830066, lng: parseFloat(this.settings.center_longitude) || -85.689583},
                styles: (this.settings.styles ? JSON.parse(this.settings.styles) : false),
                disableDefaultUI: (this.settings.ui === 'on'),
                scrollwheel: !(this.settings.scrollwheel === 'on'),
                disableDoubleClickZoom: (this.settings.dblclick === 'on')
            });
            
            if (this.settings.marker_latitude && this.settings.marker_longitude) {
                new window.google.maps.Marker({position: {lat: parseFloat(this.settings.marker_latitude), lng: parseFloat(this.settings.marker_longitude)}, map: window.gmap});
            }

            window.google.maps.event.trigger(window.gmap, 'resize');
        }
    }
    
    injectGoogleMaps() {
        const endpoint = `https://maps.googleapis.com/maps/api/js?key=${this.settings.api_key}&callback=initGoogleMap`;
        const script = document.createElement('script');
        script.async = true;
        script.defer = true;
        script.setAttribute('src', endpoint);
        document.head.appendChild(script);
    }
}

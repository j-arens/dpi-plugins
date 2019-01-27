import DpiMapsClient from './client';

if (!window.hasOwnProperty('DpiMapsClient')) {
    window.DpiMapsClient = new DpiMapsClient('#dpi-maps-root', window.dpiMapsSettings);
}
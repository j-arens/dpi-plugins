import * as model from './model';
import * as controller from './controller';
// import css from '../../css/backend/main.css';

window.dpiSuperMenu = (function() {

  /**
  * Load in application state
  */
  const state = model.loadState();
  // const state = model.default;

  /**
  * Run these functions on startup
  */
  function init() {
    cacheDom();
    renderRoot();
  }

  /**
  * Cache the root selector for efficiency and for use throughout the app
  */
  function cacheDom() {
    state.root = document.getElementById('dpi-sm-editor-root');
  }

  /**
  * Render the top level component, through which all other actions take place
  */
  function renderRoot() {
    if (state.root) {
      controller.createComponent(state, 'ItemType', controller.queryModel(state, 'get', 'ItemType'));
    }
  }

  /**
  * Public methods and variables
  */
  return {
    state: state, // for dev only
    init: init,
    events: state.events,
    root() {
      return state.root;
    },
    component(component, props) {
      return controller.createComponent(state, component, props);
    },
    deleteComponent(component) {
      controller.deleteComponent(state, component);
    },
    instance(type, id, props) {
      return controller.createInstance(state, type, id, props);
    },
    deleteInstance(type, id) {
      controller.deleteInstance(state, type, id);
    },
    update(obj) {
      controller.queryModel(state, 'set', obj);
    },
    getProps(component) {
      return controller.queryModel(state, 'get', component);
    },
    saveState() {
      model.saveState(state);
    }
  }
})();

// kick things off
window.dpiSuperMenu.init();

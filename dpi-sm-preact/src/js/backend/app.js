import { h, render } from 'preact';
import { bindActionCreators } from 'redux';
import { Provider, connect } from 'preact-redux';
import * as actions from './actions';
import model from './model';

// componenets
import Main from './components/Main';

window.dpiSuperMenu = (function() {

  let appRoot;

  function wpMediaPicker(id, callback) {
    if (!window.dpiSuperMenu.hasOwnProperty('mediaWindow')) {
      window.dpiSuperMenu.mediaWindow = wp.media({
        title: 'Insert Image',
        library: {type: 'image'},
        multiple: false,
        button: {text: 'insert'}
      });

      window.dpiSuperMenu.mediaWindow.on('select', () => {
        const data = window.dpiSuperMenu.mediaWindow.state().get('selection').first().toJSON();
        const imageURL = data.sizes.medium.url;
        const imageID = data.id;
        callback(window.dpiSuperMenu.img_uid, imageURL, imageID);
      });
    }

    window.dpiSuperMenu.img_uid = id;
    window.dpiSuperMenu.mediaWindow.open();
    return false;
  }

  function _mapStateToProps(model) {
    return model.settings;
  }

  function _mapDispatchToProps(dispatch) {
    return bindActionCreators(actions, dispatch);
  }

  function _renderRoot() {
    if (appRoot) {
      const App = connect(_mapStateToProps, _mapDispatchToProps)(Main);
      render(
        <Provider store={model}>
          <App />
        </Provider>,
        appRoot,
        appRoot.firstElementChild
      );
    }
  }

  function _cacheDom() {
    appRoot = document.getElementById('dpi-sm-editor-root');
  }

  function init() {
    _cacheDom();
    _renderRoot();
  }

  return {
    init: init,
    root() {
      return appRoot;
    },
    mediaPicker(id, cb) {
      return wpMediaPicker(id, cb);
    }
  }

})();

window.dpiSuperMenu.init();

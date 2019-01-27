import dispatcher from '../Dispatcher';

// stores
import pagesStore from '../stores/PagesStore';
import sectionsStore from '../stores/SectionsStore';
import componentsStore from '../stores/ComponentsStore';
import elementsStore from '../stores/ElementsStore';
import fieldsStore from '../stores/FieldsStore';

// ajax in state from previous session
export function loadState() {
  dispatcher.dispatch({
    type: 'FETCH_PREV_STATE',
  });

  const $ = window.jQuery;
  const url = window.ajaxurl;
  const data = {'action': 'get_state'};

  function dispatch(obj) {
    dispatcher.dispatch({
      type: 'RECEIVE_STATE',
      pages: obj['pages'] || [],
      sections: obj['sections'] || [],
      components: obj['components'] || [],
      elements: obj['elements'] || [],
      fields: obj['fields'] || []
    });
  }

  if ($ && url) {
    $.get(url, data)
      .done((res) => {
        if (typeof res === 'object') {
          dispatch(res);
        } else {
          let parsed_state = JSON.parse(res);

          if (typeof parsed_state !== 'object') {
            dispatcher.dispatch({
              type: 'FETCH_STATE_ERROR',
              msg: 'Unable to parse JSON!'
            });
            return false;
          }

          function convertInt(el, innerKey) {
            const intProps = ['id', 'section', 'component', 'element', 'field'];
            intProps.forEach((intProp) => {
              if (innerKey === intProp) {
                el[innerKey] = parseInt(el[innerKey]);
              }
            });
          }

          function convertBool(el, innerKey) {
            const boolProps = ['collapse'];
            boolProps.forEach((boolProp) => {
              if (innerKey === boolProp) {
                const str = el[innerKey];
                if (str === 'true') {
                  el[innerKey] = true;
                } else {
                  el[innerKey] = false;
                }
              }
            });
          }

          // convert parsed string id's back to integer
          Object.keys(parsed_state).forEach((key) => {
            if (parsed_state[key].length) {
                parsed_state[key].forEach((el) => {
                  Object.keys(el).forEach((innerKey) => {
                    convertInt(el, innerKey);
                    convertBool(el, innerKey);
                  });
                });
              }
          });
          dispatch(parsed_state);
        }
      })
      .fail(() => {
        dispatcher.dispatch({
          type: 'FETCH_STATE_ERROR',
          msg: 'Get request failed.'
        });
      });
  } else {
    dispatcher.dispatch({
      type: 'FETCH_STATE_ERROR',
      msg: 'Window varibles not found!',
    });
  }



  // setTimeout(() => {
  //   const state = {
  //     pages: [
  //       {id: 1, name: 'Settings'},
  //       {id: 2, name: 'Builder'},
  //       {id: 3, name: 'Colors'},
  //       {id: 4, name: 'Typography'}
  //     ],
  //     sections: [],
  //     components: [],
  //     elements: [],
  //     fields: [],
  //   };
  //
  //   dispatcher.dispatch({
  //     type: 'RECEIVE_STATE',
  //     pages: state.pages,
  //     sections: state.sections,
  //     components: state.components,
  //     elements: state.elements,
  //     fields: state.fields,
  //   });
  // }, 1000);
}

// ajax out current state
export function saveState() {
  dispatcher.dispatch({
    type: 'POST_CURRENT_STATE',
    msg: 'Calling home...',
    status: 'success',
  });

  const $ = window.jQuery;
  const url = window.ajaxurl;

  if ($ && url) {
    const state = {
      pages: pagesStore.getAll(),
      sections: sectionsStore.getAll(),
      components: componentsStore.getAll(),
      elements: elementsStore.getAll(),
      fields: fieldsStore.getAll(),
    }
    const data = {
      'action': 'save_state',
      'state': state
    }

    $.post(url, data)
      .done(() => {
        dispatcher.dispatch({
          type: 'POST_STATE_SUCCESS',
          msg: 'Settings Saved!',
          status: 'success',
        });
      })
      .fail(() => {
        dispatcher.dispatch({
          type: 'POST_STATE_ERROR',
          msg: 'Error, post request failed.',
          status: 'alert',
        });
      });
  } else {
    dispatcher.dispatch({
      type: 'POST_STATE_ERROR',
      msg: 'Error, window varibles not found!',
      status: 'alert',
    });
  }
}

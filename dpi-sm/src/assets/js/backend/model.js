import Emitter from './Emitter';

const state = {

  /**
  * Raw data model of application state
  */
  post_id: null,
  root: '',
  events: new Emitter(),
  classContainer: {},
  components: {
    ItemType: {
      instantiated: false,
      selector: '.ItemType',
      rootSelector: '#ItemType-root',
      legendTitle: 'New Menu Item',
      menuItemName: '',
      menuItemType: '',
    },
    CustomLink: {
      instantiated: false,
      rootSelector: '#menuItemType-root',
      selector: '.CustomLink',
      linkName: '',
      targetBlank: false,
    },
    CustomSection: {
      instantiated: false,
      rootSelector: '#menuItemType-root',
      selector: '.CustomSection',
    },
    EditorControls: {
      instantiated: false,
      rootSelector: '.dpi-sm-custom-section-options',
      selector: '.dpi-sm-editor-controls'
    },
    ModelNav: {
      instantiated: false,
      rootSelector: '#ModelNav-root',
      navItems: ['Item 1', 'Item 2'],
    },
    DropBar: {
      instantiated: false,
      rootSelector: '#dropBar-root',
      count: 1,
    },
    Column: {
      instances: []
    },
    ColumnControls: {
      instances: []
    },
    ColumnTypeSelector: {
      instances: [],
    },
    Blank: {
      instances: []
    },
    SubMenu: {
      instances: [],
    }
  }
}

/**
* Parse the json from the localized dpism_pod object.
* Seed the model with the data, return the model.
*/
export function loadState() {
  // console.log(window.dpism_pod.wrapped_state);
  if (window.dpism_pod.wrapped_state && window.dpism_pod.wrapped_state !== undefined) {
    const wrapped_state = JSON.parse(window.dpism_pod.wrapped_state);

    for (const key in wrapped_state) {
      state[key] = wrapped_state[key];
    }

    for (const comp in state.components) {
      if (state.components[comp].hasOwnProperty('instantiated')) {
        state.components[comp].instantiated = false;
      }
    }

    state.components.ModelNav.navItems = window.dpism_pod.menu_items;

    // reset post id, classContainer, and events
    // state.post_id = window.dpism_pod.post_id;
    state.classContainer = {};
    state.events = new Emitter;

    // console.log(state);

    return state;
  } else {
    console.log('returning new state');
    return state;
  }
}

/**
*
*/
// export function saveState(state) {
//   if (window.ajaxurl) {
//
//     const data = {
//       'action': 'dpism_save_state',
//       'state': state
//     };
//
//     const request = new XMLHttpRequest();
//     request.open('POST', window.ajaxurl, true);
//     request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
//     request.send(data);
//     console.log(request.status);
//
//   } else {
//     console.error('DPI Super Menu: Unable to save state!');
//   }
// }

export function saveState(state) {
  // const request = new XMLHttpRequest();
  // request.open('POST', window.dpism_pod.rest_url + 'wp/v2/dpi-sm', true);
  // request.setRequestHeader('X-WP-Nonce', window.dpism_pod.nonce);
  // request.send(data);

  const $ = jQuery;

  console.log(JSON.stringify(state));

   $.ajax({
     method: 'POST',
     url: window.dpism_pod.rest_url + 'wp/v2/dpi-sm',
     data: {
       title: state.components.ItemType.menuItemName,
       id: window.dpism_pod.ID,
       author: window.dpism_pod.user_id,
       content: JSON.stringify(state),
       slug: state.components.ItemType.menuItemName.replace(' ', '-'),
       status: 'publish'
     },
     beforeSend: function(xhr) {
       xhr.setRequestHeader('X-WP-Nonce', window.dpism_pod.nonce);
     },
     success: function(res) {
       console.log('success', res);
     },
     fail: function(err) {
       console.log('fail', err);
     }
   });
}

export default state;

import { createStore } from 'redux';
import rootReducer from './reducers';
import devToolsEnhancer from 'remote-redux-devtools';

const model = createStore(rootReducer, {
  settings: {
    name: '',
    type: ''
  },
  customLink: {
    url: '',
    targetBlank: false
  },
  customSection: {
    columns: [
      {type: 'Blank', id: 1, instance: 'Blank'}
    ]
  },
  instances: {
    ColumnTypeSelector: [{id: 1}],
    Blank: [{id: 1}],
    Image: [],
    SubMenu: [],
    Search: [],
    Shortcode: [],
    RawHTML: []
  }
}, devToolsEnhancer({realtime: true}));

export function loadState() {

}

export function saveState() {

}

export default model;

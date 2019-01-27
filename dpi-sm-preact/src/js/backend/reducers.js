import { combineReducers } from 'redux';

const EMPTY = {};

function settings(state = state || EMPTY, action) {
  switch(action.type) {
    case 'CHANGE_ITEMNAME':
      return Object.assign({}, state, {
        name: action.name
      });
    case 'CHANGE_ITEMTYPE':
      return Object.assign({}, state, {
        type: action.itemType
      });
    default:
      return state;
  }
}

function customLink(state = state || EMPTY, action) {
  switch(action.type) {
    case 'CHANGE_LINKURL':
      return Object.assign({}, state, {
        url: action.url
      });
    case 'CHANGE_TARGETBLANK':
      return Object.assign({}, state, {
        targetBlank: action.blank
      });
    default:
      return state;
  }
}

function customSection(state = state || EMPTY, action) {
  switch(action.type) {
    case 'ADD_COLUMN':
      return Object.assign({}, state, {
        columns: [...state.columns, {type: action.columnType, id: Math.floor((1 + Math.random()) * 0x10000)}]
      });
    case 'DELETE_COLUMN':
      state.columns.splice(state.columns.findIndex(col => col.id === action.id), 1);
      return Object.assign({}, state, {
        columns: [...state.columns]
      });
    case 'CHANGE_COLUMN_ORDER':
      return Object.assign({}, state, {
        columns: [...action.order.map(id => state.columns[state.columns.findIndex(col => col.id === parseFloat(id))])]
      });
    case 'CHANGE_COLUMN_INSTANCE':
      state.columns.find(col => col.id === action.id).instance = action.instance;
      return Object.assign({}, state, {
        columns: [...state.columns]
      });
    default:
      return state;
  }
}

function instances(state = state || EMPTY, action) {
  switch(action.type) {
    case 'DELETE_COLUMN':
      for (let instance in state) {
        state[instance] = state[instance].filter(inst => inst.id !== action.id);
      }
      return Object.assign({}, state, {
        ColumnTypeSelector: [...state.ColumnTypeSelector],
        Blank: [...state.Blank],
        Image: [...state.Image],
        SubMenu: [...state.SubMenu],
        Search: [...state.Search],
        Shortcode: [...state.Shortcode],
        RawHTML: [...state.RawHTML]
      });
    case 'CHANGE_COLUMN_INSTANCE':
      if (!state[action.instance].find(inst => inst.id === action.id)) {
        switch (action.instance) {
          case 'ColumnTypeSelector':
            state.ColumnTypeSelector.push({id: action.id});
            break;
          case 'Blank':
            state.Blank.push({id: action.id});
            break;
          case 'Image':
            state.Image.push({id: action.id, hasImage: false, imageURL: '', imageID: ''});
            break;
          case 'SubMenu':
            state.SubMenu.push({id: action.id, hasMenu: false});
            break;
          case 'Search':
            state.search.push({id: action.id});
            break;
          case 'Shortcode':
            state.Shortcode.push({id: action.id, hasShortcode: false, shortcode: ''});
            break;
          case 'RawHTML':
            state.RawHTML.push({id: action.id, hasHTML: false, html: ''});
            break;
        }
      }
      return Object.assign({}, state, {
        ColumnTypeSelector: [...state.ColumnTypeSelector],
        Blank: [...state.Blank],
        Image: [...state.Image],
        SubMenu: [...state.SubMenu],
        Search: [...state.Search],
        Shortcode: [...state.Shortcode],
        RawHTML: [...state.RawHTML]
      });
    case 'ADD_IMAGE':
      const instance = state.Image.find(inst => inst.id === action.id);
      instance.hasImage = true;
      instance.imageURL = action.imageURL;
      instance.imageID = action.imageID;
      return Object.assign({}, state, {
        Image: [...state.Image],
      });
    default:
      return state;
  }
}

const rootReducer = combineReducers({
  settings,
  customLink,
  customSection,
  instances
});

export default rootReducer;

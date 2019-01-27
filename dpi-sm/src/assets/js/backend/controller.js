// components
import ItemType from './components/ItemType';
import CustomLink from './components/CustomLink';
import CustomSection from './components/CustomSection';
import ModelNav from './components/ModelNav';
import DropBar from './components/DropBar';
import SubMenu from './components/SubMenu';
import EditorControls from './components/EditorControls';
import Blank from './components/Blank';
import ColumnControls from './components/ColumnControls';
import ColumnTypeSelector from './components/ColumnTypeSelector';

// get and set functions
import * as get from './get';
import * as set from './set';

/**
* All declarative component creation goes through here.
* If the component has already been instantiated, give it new props and call render again.
*
* @param {object} state - state to manipulate
* @param {string} component - name of the component
* @param {object} props - props to be passed to the component
*
*/
export function createComponent(state, component, props) {
  const components = {
    ItemType,
    CustomLink,
    CustomSection,
    EditorControls,
    ModelNav,
    DropBar,
  };

  if (state.components.hasOwnProperty(component) && !state.components[component].instantiated) {
    switch(component) {
      case 'ItemType':
        state.classContainer.ItemType = new ItemType(props);
        state.components.ItemType.instantiated = true;
        break;
      default:
        state.classContainer[component] = new components[component](props);
        state.components[component].instantiated = true;
        return state.classContainer[component].render();
    }
  } else {
    state.classContainer[component].props = props;
    return state.classContainer[component].render();
  }
}


/**
* All declarative component deletion goes through here.
* Make sure component exists and has been instantiated before removing.
*
* @param {object} state - state to manipulate
* @param {string} component - name of the component
*
*/
export function deleteComponent(state, component) {
  if (state.components.hasOwnProperty(component) && state.components[component].instantiated) {

    if ('dismount' in state.classContainer[component]) {
      state.classContainer[component].dismount();
    }

    state.classContainer[component] = undefined;
    state.components[component].instantiated = false;
    state.events.emit(`${component}_removed`);
  } else {
    return false;
  }
}

/**
* All declarative instance creation goes through here.
* Instances are basically components but need to be treated differently.
* Check if the instance already exists, if it does pass new props and call render.
* Otherwise create a new instance and call render.
*
* @param {object} state - state to manipulate
* @param {string} type - type of the instance
* @param {number} id - id of the instance
* @param {object} props - props to passed to the instance
*
*/
export function createInstance(state, type, id, props) {
  const instance = state.components[type].instances.filter(inst => inst.id === id)[0];
  const instances = {
    Blank,
    ColumnControls,
    ColumnTypeSelector,
    SubMenu
  }

  if (instance && instance.render) {
    instance.props = props;
    return instance.render();
  } else {
    const inst = new instances[type]();
    inst.id = id;
    state.components[type].instances.push(inst);
    return inst.render();
  }
}

/**
* All declarative instance deletion goes through here.
* Check if instance exists before trying to remove it.
*
* @param {object} state - state to manipulate
* @param {string} type - type of instance
* @param {number} id - id of instance
*
*/
export function deleteInstance(state, type, id) {
  const instance = state.components[type].instances.filter(inst => inst.id === id)[0];
  if (instance) {

    if ('dismount' in instance) {
      instance.dismount();
    }

    state.components[type].instances.splice(state.components[type].instances.findIndex(inst => inst.id === id), 1);
    state.events.emit(`${type}_removed`, id);
  } else {
    return false;
  }
}

/**
* Provides all the routing to the model setters and getters,
* Compute the method, check to make sure it exists, run conditional logic.
*
* @param {object} state - state that contains the getters and setters
* @param {string} action - either set or get
* @param {string} / {object} params - name of the setter or getter and any additional data
*
*/
export function queryModel(state, action, params) {
  const method = `${action}_${params.prop || params}`;
  if (action === 'get' && get[method]) {
    const data = get[method](state);
    if (data.instances && params.id) {
      return data.instances.filter(inst => inst.id === params.id)[0];
    } else {
      return data;
    }
  } else if (action === 'set' && set[method]) {
    set[method](state, params);
  }
}

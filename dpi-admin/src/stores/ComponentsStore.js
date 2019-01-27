import { EventEmitter } from 'events';

// dispatcher
import dispatcher from '../Dispatcher';

// stores
import idStore from '../stores/IdStore';

class ComponentsStore extends EventEmitter {
  constructor() {
    super();
    this.components = [];
  }

  loadState(state) {
    this.components = state;
    this.emit('componentAdded');
  }

  getAll() {
    return this.components;
  }

  getChildren(id) {
    return this.components.filter(comp => comp.section === id);
  }

  getComponent(id) {
    let childComponent = null;
    if (this.components.length) {
      this.components.forEach((component) => {
        if (component.id === id) {
          childComponent = component;
        }
      });
      return childComponent;
    }
  }

  addComponent(section, name) {
    const id = idStore.createId();

    this.components.push({id, name, section, collapse: false});

    this.emit('componentAdded');
  }

  removeComponent(id) {
    if (this.components.length) {
      this.components.forEach((component, i) => {
        if (component.id === id) {
          this.components.splice(i, 1);
        }
      });
      idStore.removeId(id);
      this.emit('componentRemoved');
    }
  }

  removeAll(sectionId) {
    if (this.components.length) {
      // run in reverse so that splice() doesnt skip
      for (let i = this.components.length - 1; i >= 0; i--) {
        if (this.components[i].section === sectionId) {
          idStore.removeId(this.components[i].id);
          this.components.splice(i, 1);
        }
      }
      this.emit('componentRemoved');
    }
  }

  toggleCollapse(id) {
    if (this.components.length) {
      this.components.forEach((component) => {
        if (component.id === id) {
          component.collapse = !component.collapse;
          this.emit('masonryReload');
        }
      });
    }
  }

  handleActions(action) {
    switch(action.type) {
      case 'RECEIVE_STATE':
        this.loadState(action.components);
        break;
      case 'ADD_COMPONENT':
        this.addComponent(action.section, action.name);
        break;
      case 'DELETE_COMPONENT':
        this.removeComponent(action.id);
        break;
      case 'DELETE_SECTION':
        this.removeAll(action.id);
        break;
      default:
        break;
    }
  }
}

const componentsStore = new ComponentsStore();
window.componentsStore = componentsStore;
dispatcher.register(componentsStore.handleActions.bind(componentsStore));
export default componentsStore;

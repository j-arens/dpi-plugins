import { EventEmitter } from 'events';

// stores
import idStore from '../stores/IdStore';

// dispatcher
import dispatcher from '../Dispatcher';

class ElementsStore extends EventEmitter {
  constructor() {
    super();
    this.elements = [];
  }

  loadState(state) {
    this.elements = state;
    this.emit('elementAdded');
  }

  getAll() {
    return this.elements;
  }

  getElement(id) {
    let childElement = null;
    if (this.elements.length) {
      this.elements.forEach((element) => {
        if (element.id === id) {
          childElement = element;
        }
      });
      return childElement;
    }
  }

  getChildren(prop, id) {
    let children = [];
    this.elements.forEach((element) => {
      if (element[prop] === id) {
        children.push(element);
      }
    });
    return children;
  }

  addElement(section, component, name) {
    const id = idStore.createId();

    this.elements.push({id, section, component, name, collapse: false});
    this.emit('elementAdded');
  }

  removeElement(id) {
    if (this.elements.length) {
      this.elements.forEach((element, i) => {
        if (element.id === id) {
          this.elements.splice(i, 1);
        }
      });
      idStore.removeId(id);
      this.emit('elementRemoved');
    }
  }

  removeAll(parent, id) {
    if (this.elements.length) {
      // run in reverse so that splice() doesn't skip
      for (let i = this.elements.length - 1; i >= 0; i--) {
        if (this.elements[i][parent] === id) {
          idStore.removeId(this.elements[i].id);
          this.elements.splice(i, 1);
        }
      }
      this.emit('elementRemoved');
    }
  }

  toggleCollapse(id) {
    if (this.elements.length) {
      this.elements.forEach((element) => {
        if (element.id === id) {
          element.collapse = !element.collapse;
          this.emit('masonryReload');
        }
      });
    }
  }

  handleActions(action) {
    switch(action.type) {
      case 'RECEIVE_STATE':
        this.loadState(action.elements);
        break;
      case 'ADD_ELEMENT':
        this.addElement(action.section, action.component, action.name);
        break;
      case 'DELETE_ELEMENT':
        this.removeElement(action.id);
        break;
      case 'DELETE_SECTION':
        this.removeAll('section', action.id);
        break;
      case 'DELETE_COMPONENT':
        this.removeAll('component', action.id);
        break;
      default:
        break;
    }
  }
}

const elementsStore = new ElementsStore();
dispatcher.register(elementsStore.handleActions.bind(elementsStore));
export default elementsStore;

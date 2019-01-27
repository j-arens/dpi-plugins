import { EventEmitter } from 'events';

// dispatcher
import dispatcher from '../Dispatcher';

// stores
import idStore from '../stores/IdStore';

class FieldsStore extends EventEmitter {
  constructor() {
    super();
    this.fields = [];
  }

  loadState(state) {
    this.fields = state;
    this.emit('fieldAdded');
  }

  isValid(str) {
    const regex = /^$|[a-zA-Z\d\@#!.$%="'()&-_\[/\]/\s]+/g;
    return regex.test(str);
  }

  removeSpaces(delta) {
    if (typeof delta === 'string') {
      return delta.replace(/ /g, '_');
    } else {
      return delta;
    }
  }

  getAll() {
    return this.fields;
  }

  getChildren(prop, id) {
    let children = [];
    this.fields.forEach((field) => {
      if (field[prop] === id) {
        children.push(field);
      }
    });
    return children;
  }

  addField(section, component, element, type) {
    const id = idStore.createId();
    this.fields.push({
      section,
      component,
      element,
      id,
      type,
      name: '',
      desc: '',
      val: '',
      collapse: false,
    });
    this.emit('fieldAdded');
  }

  updateField(id, prop, delta) {
    if (this.fields.length) {
      this.fields.forEach((field) => {
        if (field.id === id && this.isValid(delta) === true) {
          if (prop === 'name') {
            field[prop] = this.removeSpaces(delta);
          } else {
            field[prop] = delta;
          }
          this.emit('fieldUpdated');
        }
      });
    }
  }

  removeField(id) {
    if (this.fields.length) {
      this.fields.forEach((field, i) => {
        if (field.id === id) {
          this.fields.splice(i, 1);
        }
      });
      idStore.removeId(id);
      this.emit('fieldRemoved');
    }
  }

  removeAll(parent, id) {
    if (this.fields.length) {
      // run in reverse so that splice() doesn't skip
      for (let i = this.fields.length - 1; i >= 0; i--) {
        if (this.fields[i][parent] === id) {
          idStore.removeId(this.fields[i].id);
          this.fields.splice(i, 1);
        }
      }
      this.emit('fieldRemoved');
    }
  }

  toggleCollapse(id) {
    if (this.fields.length) {
      this.fields.forEach((field) => {
        if (field.id === id) {
          field.collapse = !field.collapse;
          this.emit('masonryReload');
        }
      });
    }
  }

  handleActions(action) {
    switch(action.type) {
      case 'RECEIVE_STATE':
        this.loadState(action.fields);
        break;
      case 'ADD_FIELD':
        this.addField(action.section, action.component, action.element, action.fieldType);
        break;
      case 'DELETE_FIELD':
        this.removeField(action.id);
        break;
      case 'UPDATE_FIELD':
        this.updateField(action.id, action.prop, action.delta);
        break;
      case 'DELETE_SECTION':
        this.removeAll('section', action.id);
        break;
      case 'DELETE_COMPONENT':
        this.removeAll('component', action.id);
        break;
      case 'DELETE_ELEMENT':
        this.removeAll('element', action.id);
        break;
      default:
        break;
    }
  }
}

const fieldsStore = new FieldsStore();
window.fieldsStore = fieldsStore;
dispatcher.register(fieldsStore.handleActions.bind(fieldsStore));
export default fieldsStore;

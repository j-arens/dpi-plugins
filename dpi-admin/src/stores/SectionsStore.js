import { EventEmitter } from 'events';

// dispatcher
import dispatcher from '../Dispatcher';

// stores
import idStore from '../stores/IdStore';

class SectionsStore extends EventEmitter {
  constructor() {
    super();
    this.sections = [];
  }

  loadState(state) {
    this.sections = state;
    this.emit('sectionAdded');
  }

  getAll() {
    return this.sections;
  }

  getSection(id) {
    let childSection = null;
    if (this.sections.length) {
      this.sections.forEach((section) => {
        if (section.id === id) {
          childSection = section;
        }
      });
      return childSection;
    }
  }

  toggleCollapse(id) {
    if (this.sections.length) {
      this.sections.forEach((section) => {
        if (section.id === id) {
          section.collapse = !section.collapse;
          this.emit('masonryReload');
        }
      });
    }
  }

  addSection(name, id) {
    this.sections.push({id, name, collapse: false});
    this.emit('sectionAdded');
  }

  removeSection(id) {
    this.sections.forEach((section, i) => {
      if (section.id === id) {

        this.sections.splice(i, 1);
        idStore.removeId(id);
        this.emit('sectionRemoved');
      }
    });
  }

  handleActions(action) {
    switch(action.type) {
      case 'RECEIVE_STATE':
        this.loadState(action.sections);
        break;
      case 'ADD_SECTION':
        this.addSection(action.name, action.id);
        break;
      case 'DELETE_SECTION':
        this.removeSection(action.id);
        break;
      default:
        break;
    }
  }
}

const sectionsStore = new SectionsStore();
dispatcher.register(sectionsStore.handleActions.bind(sectionsStore));
export default sectionsStore;

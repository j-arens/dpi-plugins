import { EventEmitter } from 'events';

// dispatcher
import dispatcher from '../Dispatcher';

class PagesStore extends EventEmitter {
  constructor() {
    super();
    this.pages = [];
  }

  loadState(state) {
    this.pages = state;
    this.emit('pageAdded');
  }

  getAll() {
    return this.pages;
  }

  getVisible() {
    const user = window._current_user_info_;
    let visiblePages = [];

    if (!user) {
      dispatcher.dispatch({
        type: 'GET_USER_ERROR',
        msg: 'Unable to get user role. Admin capabilities disabled.',
        status: 'warning',
      });
    } else {
      if (user.roles[0] === 'administrator') {
        visiblePages = this.pages;
      } else {
        visiblePages = this.pages.filter((page) => {
          if (page.id > 1) {
            return true;
          }
        });
      }
    }
    return visiblePages;
  }

  createPage(id, name) {
    this.pages.push({ id, name });

    this.emit('pageAdded');
  }

  removePage(id) {
    if (this.pages.length) {
      this.pages.forEach((page, i) => {
        if (page.id === id) {
          this.pages.splice(i, 1);
        }
      });
      this.emit('pageRemoved');
    }
  }

  fetchError(msg) {
    this.pagesStore = msg;
    this.emit('fetchError');
  }

  errMsg() {
    return this.pagesStore;
  }

  loading() {
    this.emit('savingState');
  }

  handleActions(action) {
    switch(action.type) {
      case 'POST_CURRENT_STATE':
        this.loading();
        break;
      case 'FETCH_STATE_ERROR':
        this.fetchError(action.msg);
        break;
      case 'RECEIVE_STATE':
        this.loadState(action.pages);
        break;
      case 'ADD_SECTION':
        this.createPage(action.id, action.name);
        break;
      case 'DELETE_SECTION':
        this.removePage(action.id);
        break;
      default:
        break;
    }
  }
}

const pagesStore = new PagesStore();
dispatcher.register(pagesStore.handleActions.bind(pagesStore));
export default pagesStore;

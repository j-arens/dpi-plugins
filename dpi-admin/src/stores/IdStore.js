import { EventEmitter } from 'events';

// dispatcher
import dispatcher from '../Dispatcher';

class IdStore extends EventEmitter {
  constructor() {
    super();
    
    this.ids = [];
  }

  createId() {
    let stopLoop = false;
    let newId = Math.floor((1 + Math.random()) * 0x100);

    while(!stopLoop) {
      if (this.ids.length) {
        loopIds(this);
      } else {
        stopLoop = true;
      }
    }

    function loopIds(t) {
      t.ids.forEach((id) => {
        if (id === newId && newId > 4) {
          newId = Math.floor((1 + Math.random()) * 0x100);
        } else {
          stopLoop = true;
        }
      });
    }

    this.ids.push(newId);
    return newId;
  }

  removeId(id) {
    if (this.ids.length) {
      this.ids.forEach((uid, i) => {
        if (uid === id) {
          this.ids.splice(i, 1);
        }
      });
    }
  }

  handleActions(action) {
    switch(action.type) {
      default:
        break;
    }
  }
}

const idStore = new IdStore();
dispatcher.register(idStore.handleActions.bind(idStore));
export default idStore;

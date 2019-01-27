export default class Emitter {
  constructor() {
    this.events = {};
  }

  on(eventName, fn) {
    const token = (((1+Math.random())*0x10000)|0).toString(16).substring(1);
    this.events[eventName] = this.events[eventName] || [];
    this.events[eventName].push({token, fn});
    return token;
  }

  off(eventName, token) {
    if (this.events.hasOwnProperty(eventName)) {
      this.events[eventName].splice(this.events[eventName].findIndex(obj => obj.token === token), 1);
    }
  }

  emit(eventName, data) {
    if (this.events.hasOwnProperty(eventName)) {
      this.events[eventName].forEach(obj => obj.fn(data));
    }
  }
}

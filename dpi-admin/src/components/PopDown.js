import React from 'react';

// dispatcher
import dispatcher from '../Dispatcher';

// styles
import popdownStyle from '../styles/_popdown.css';

// icons
// import CloseIcon from '../icons/Close';

export default class PopDown extends React.Component {
  constructor() {
    super();

    this.handleActions = this.handleActions.bind(this);

    this.state = {
      msg: '',
      status: '',
      visible: false,
      latestTimer: 0,
    }
  }

  componentWillMount() {
    dispatcher.register(this.handleActions);
  }

  componentWillUnmount() {
    dispatcher.unregister(this.handleActions);
  }

  timer() {
    const currentTimer = this.state.latestTimer;
    this.setState({latestTimer: this.state.latestTimer++});
    let timerId = setInterval(() => {
      this.closePopDown(timerId, currentTimer);
    }, 2000);
  }

  openPopDown(msg, status) {
    this.setState({
      msg,
      status,
      visible: true,
    });
    this.timer();
  }

  closePopDown(intervalId, currentTimer) {
    clearInterval(intervalId);

    if (this.state.latestTimer === currentTimer) {
      this.setState({
        msg: '',
        type: '',
        visible: false,
      });
    }
  }

  handleActions(action) {
    switch(action.type) {
      case 'POST_CURRENT_STATE':
        this.openPopDown(action.msg, action.status);
        break;
      case 'POST_STATE_SUCCESS':
        this.openPopDown(action.msg, action.status);
        break;
      case 'POST_STATE_ERROR':
        this.openPopDown(action.msg, action.status);
        break;
      case 'GET_USER_ERROR':
        this.openPopDown(action.msg, action.status);
        break;
      default:
        break;
    }
  }

  render() {
    return (
      <div className={[popdownStyle.popdown, popdownStyle[this.state.status], this.state.visible === true ? popdownStyle.slideDown : popdownStyle.slideUp].join(' ')}>
        <p>{this.state.msg}</p>
      </div>
    );
  }
}

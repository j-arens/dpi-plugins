import React from 'react';

// icons
import CloseIcon from '../icons/Close';

// styles
import style from '../styles/_controls.css';

export default class CreatorControls extends React.Component {
  render() {
    return (
        <div className={style.controls}>
          <button onClick={this.props.closeModal} className={style.controlBtn}><CloseIcon /></button>
        </div>
    );
  }
}

CreatorControls.propTypes = {
  closeModal: React.PropTypes.func,
}

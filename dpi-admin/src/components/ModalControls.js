import React from 'react';

// icons
import DownArrowIcon from '../icons/DownArrow';
import TrashCanIcon from '../icons/TrashCan';
import PlusSquareIcon from '../icons/PlusSquare';

// styles
import style from '../styles/_controls.css';
import btnStyles from '../styles/_buttons.css';

export default class ModalControls extends React.Component {
  render() {
    return (
        <div className={style.controls}>
          <button onClick={this.props.accordionControl} className={[style.controlBtn, btnStyles.btn].join(' ')}><DownArrowIcon /></button>
          {this.props.isSection === true ? <button onClick={this.props.option} className={[style.controlBtn, btnStyles.btn].join(' ')}><PlusSquareIcon /></button> : ''}
          <button onClick={this.props.closeModal} className={[style.controlBtn, btnStyles.btn].join(' ')}><TrashCanIcon /></button>
        </div>
    );
  }
}

ModalControls.propTypes = {
  option: React.PropTypes.func,
  closeModal: React.PropTypes.func,
  accordionControl: React.PropTypes.func,
  isSection: React.PropTypes.bool.isRequired,
}

import React from 'react';

// actions
import * as FieldActions from '../actions/FieldActions';

// components
import ModalControls from './ModalControls';

// styles
import modalStyle from '../styles/_modals.css';
import titlebarStyles from '../styles/_titlebars.css';
import controlStyles from '../styles/_controls.css';

export default class BuilderPasswordField extends React.Component {
  deleteModal() {
    FieldActions.deleteField(this.props.field.id);
  }

  render() {
    const field = this.props.field;
    return (
      <div className={modalStyle.modalSm}>
        <div className={titlebarStyles.modaltitlebar}>
          <p className={titlebarStyles.title}>Password</p>
          <ModalControls isSection={false} closeModal={this.deleteModal.bind(this)}/>
        </div>
        <div className={controlStyles.fieldInput}>
          <label>
            Name
            <input onChange={(e) => {FieldActions.updateField(field.id, 'name', e.target.value)}}
            value={field.name}
            type="text" />
          </label>
          <label>
            Description
            <input onChange={(e) => {FieldActions.updateField(field.id, 'desc', e.target.value)}}
            value={field.desc}
            type="text" />
          </label>
        </div>
        <em><small>get_option( 'dpi_opt_header_quick_links_link_1_text_0' )</small></em>
      </div>
    );
  }
}

BuilderPasswordField.propTypes = {
  field: React.PropTypes.object.isRequired,
}

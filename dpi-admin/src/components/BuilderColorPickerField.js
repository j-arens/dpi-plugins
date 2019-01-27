import React from 'react';

// actions
import * as FieldActions from '../actions/FieldActions';

// stores
import fieldsStore from '../stores/FieldsStore';

// components
import ModalControls from './ModalControls';

// styles
import modalStyle from '../styles/_modals.css';
import titlebarStyles from '../styles/_titlebars.css';
import controlStyles from '../styles/_controls.css';

export default class BuilderColorPickerField extends React.Component {
  deleteModal() {
    FieldActions.deleteField(this.props.field.id);
  }

  accordionControl() {
    fieldsStore.toggleCollapse(this.props.field.id);
  }

  render() {
    const field = this.props.field;
    return (
      <div className={field.collapse === true ? [modalStyle.modalSm, controlStyles.isHidden].join(' ') : [modalStyle.modalSm, controlStyles.isVisible].join(' ')}>
        <div className={titlebarStyles.fieldTitlebar}>
          <p className={titlebarStyles.title}>Color Picker</p>
          <ModalControls
            isSection={false}
            closeModal={this.deleteModal.bind(this)}
            accordionControl={() => {this.accordionControl()}} />
        </div>
        <div className={controlStyles.fieldInput}>
          <label>
            Name
            <input onChange={(e) => {FieldActions.updateField(field.id, 'name', e.target.value)}}
            value={field.name.replace(/_/g, ' ')}
            type="text" />
          </label>
          <label>
            Description
            <input onChange={(e) => {FieldActions.updateField(field.id, 'desc', e.target.value)}}
            value={field.desc}
            type="text" />
          </label>
        </div>
        <em><small>get_option("{field.name + '_' + field.type + '_' + field.id}")</small></em>
      </div>
    );
  }
}

BuilderColorPickerField.propTypes = {
  field: React.PropTypes.object.isRequired,
}

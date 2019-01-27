import React from 'react';

// actions
import * as FieldActions from '../actions/FieldActions';

// styles
import optionsPageStyles from '../styles/_options-page.css';

export default class OptionsTextArea extends React.Component {
  render() {
    const field = this.props.field;
    return (
      <div className={optionsPageStyles.option}>
        <p className={optionsPageStyles.fieldLabel}>{this.props.field.name.replace(/_/g, ' ')}<em>{field.desc.length > 0 ? '- ' + field.desc : ''}</em></p>
        <textarea onChange={(e) => {FieldActions.updateField(field.id, 'val', e.target.value)}} value={field.val}></textarea>
      </div>
    );
  }
}

OptionsTextArea.propTypes = {
  field: React.PropTypes.object.isRequired,
}

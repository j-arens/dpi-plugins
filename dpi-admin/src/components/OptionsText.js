import React from 'react';

// actions
import * as FieldActions from '../actions/FieldActions';

// styles
import optionsPageStyles from '../styles/_options-page.css';

export default class OptionsText extends React.Component {
  render() {
    const field = this.props.field;
    return (
      <div className={optionsPageStyles.option}>
        <p className={optionsPageStyles.fieldLabel}>{field.name.replace(/_/g, ' ')}<em>{field.desc.length > 0 ? '- ' + field.desc : ''}</em></p>
        <input value={field.val} type="text" onChange={(e) => {FieldActions.updateField(field.id, 'val', e.target.value)}} />
      </div>
    );
  }
}

OptionsText.propTypes = {
  field: React.PropTypes.object.isRequired,
}

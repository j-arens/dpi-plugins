import React from 'react';

// actions
import * as FieldActions from '../actions/FieldActions';

// styles
import optionsPageStyles from '../styles/_options-page.css';

export default class OptionsSingleCheckbox extends React.Component {
  render() {
    const field = this.props.field;
    return (
      <div className={optionsPageStyles.option}>
        <p className={optionsPageStyles.fieldLabel}>{this.props.field.name}</p>
        <label className="checkbox-label">
          {field.name}
          <input value={field.val} onChange={(e) => {FieldActions.updateField(field.id, 'val', e.target.value)}} type="checkbox" />
        </label>
      </div>
    );
  }
}

OptionsSingleCheckbox.propTypes = {
  field: React.PropTypes.object.isRequired,
}

import React from 'react';
import { SketchPicker } from 'react-color';

// actions
import * as FieldActions from '../actions/FieldActions';

// styles
import optionsPageStyles from '../styles/_options-page.css';

export default class OptionsColorPicker extends React.Component {
  render() {
    const field = this.props.field;
    return (
      <div className={optionsPageStyles.option}>
        <p className={optionsPageStyles.fieldLabel}>{field.name.replace(/_/g, ' ')}<em>{field.desc.length > 0 ? '- ' + field.desc : ''}</em></p>
        <SketchPicker color={field.val} onChangeComplete={(color) => {FieldActions.updateField(field.id, 'val', color.hex)}}/>
      </div>
    );
  }
}

OptionsColorPicker.propTypes = {
  field: React.PropTypes.object.isRequired,
}

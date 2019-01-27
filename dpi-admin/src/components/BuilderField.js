import React from 'react';

// components
import BuilderTextField from './BuilderTextField';
import BuilderTextAreaField from './BuilderTextAreaField';
import BuilderPasswordField from './BuilderPasswordField';
import BuilderSecretTextField from './BuilderSecretTextField';
import BuilderSingleCheckboxField from './BuilderSingleCheckboxField';
import BuilderMultipleCheckboxField from './BuilderMultipleCheckboxField';
import BuilderRadioButtonsField from './BuilderRadioButtonsField';
import BuilderColorPickerField from './BuilderColorPickerField';
import BuilderImageUploadField from './BuilderImageUploadField';

export default class BuilderField extends React.Component {
  render() {
    switch(this.props.field.type) {
      case 'Text':
        return <BuilderTextField field={this.props.field} />
      case 'TextArea':
        return <BuilderTextAreaField field={this.props.field} />
      case 'Password':
        return <BuilderPasswordField field={this.props.field} />
      case 'SecretText':
        return <BuilderSecretTextField field={this.props.field} />
      case 'SingleCheckbox':
        return <BuilderSingleCheckboxField field={this.props.field} />
      case 'MultipleCheckbox':
        return <BuilderMultipleCheckboxField field={this.props.field} />
      case 'RadioButtons':
        return <BuilderRadioButtonsField field={this.props.field} />
      case 'ColorPicker':
        return <BuilderColorPickerField field={this.props.field} />
      case 'ImageUpload':
        return <BuilderImageUploadField field={this.props.field} />
      default:
        return <div className="disabled">Uh oh, something went wrong!</div>
    }
  }
}

BuilderField.propTypes = {
  field: React.PropTypes.object.isRequired,
}

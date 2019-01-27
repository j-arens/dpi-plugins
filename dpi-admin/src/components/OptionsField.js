import React from 'react';

// components
import OptionsText from './OptionsText';
import OptionsTextArea from './OptionsTextArea';
import OptionsMultipleCheckbox from './OptionsMultipleCheckbox';
import OptionsSingleCheckbox from './OptionsSingleCheckbox';
import OptionsColorPicker from './OptionsColorPicker';
import OptionsImageUpload from './OptionsImageUpload';

// styles
import controlsStyles from '../styles/_controls.css';

export default class OptionsField extends React.Component {
  render() {
    switch (this.props.field.type) {
      case 'Text':
        return <OptionsText field={this.props.field} />;
      case 'TextArea':
        return <OptionsTextArea field={this.props.field} />;
      case 'Password':
        return <div>Password</div>;
      case 'SecretText':
        return <div>Secret Text</div>;
      case 'SingleCheckbox':
        return <OptionsSingleCheckbox field={this.props.field} />
      case 'MultipleCheckbox':
        return <OptionsMultipleCheckbox field={this.props.field} />;
      case 'RadioButtons':
        return <div>Radio buttons</div>;
      case 'ColorPicker':
        return <OptionsColorPicker field={this.props.field} />;
      case 'ImageUpload':
        return <OptionsImageUpload field={this.props.field} />;
      default:
        return <div className={controlsStyles.noContent}>Uh oh, something went wrong!</div>
    }
  }
}

OptionsField.propTypes = {
  field: React.PropTypes.object.isRequired,
}

import React from 'react';

// stores
import fieldsStore from '../stores/FieldsStore';

// components
import OptionsField from './OptionsField';

// styles
import optionsStyles from '../styles/_options-page.css';
import controlStyles from '../styles/_controls.css';

export default class OptionsElement extends React.Component {
  render() {
    const fields = fieldsStore.getChildren('element', this.props.element.id);
    return (
      <div className={optionsStyles.optionsElement}>
        <h4 className={optionsStyles.elementTitle}>{this.props.element.name}</h4>
        {fields.length <= 0 ? <div className={controlStyles.noContent}>No fields to display yet.</div> : fields.map((field) => {
          return (
            <OptionsField key={field.id} field={field} />
          );
        })}
      </div>
    );
  }
}

OptionsElement.propTypes = {
  element: React.PropTypes.object.isRequired,
}

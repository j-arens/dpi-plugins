import React from 'react';

// stores
import elementsStore from '../stores/ElementsStore';
import fieldsStore from '../stores/FieldsStore';

// actions
import * as ElementActions from '../actions/ElementActions';
import * as FieldActions from '../actions/FieldActions';

// components
import ModalControls from './ModalControls';
import BuilderField from './BuilderField';

// styles
import modalStyles from '../styles/_modals.css';
import titlebarStyles from '../styles/_titlebars.css';
import controlStyles from '../styles/_controls.css';
import btnStyles from '../styles/_buttons.css';

export default class BuilderElement extends React.Component {
  constructor(props) {
    super(props);

    this.updateFields = this.updateFields.bind(this);

    this.state = {
      ready: function() {
        if (this.newFieldType !== '') {
          return true;
        } else {
          return false;
        }
      },
      newFieldType: '',
      fields: fieldsStore.getChildren('element', props.id),
    }
  }

  componentWillMount() {
    fieldsStore.on('fieldAdded', this.updateFields);
    fieldsStore.on('fieldRemoved', this.updateFields);
    fieldsStore.on('fieldUpdated', this.updateFields);
  }

  componentWillUnmount() {
    fieldsStore.removeListener('fieldAdded', this.updateFields);
    fieldsStore.removeListener('fieldRemoved', this.updateFields);
    fieldsStore.removeListener('fieldUpdated', this.updateFields);
  }

  updateFieldType(e) {
    this.setState({
      newFieldType: e.target.value,
    });
  }

  updateFields() {
    this.setState({
      fields: fieldsStore.getChildren('element', this.props.element.id),
    });
  }

  addField() {
    const element = this.props.element;
    FieldActions.createField(element.section, element.component, element.id, this.state.newFieldType);
  }

  deleteModal() {
    ElementActions.deleteElement(this.props.element.id);
  }

  accordionControl() {
    elementsStore.toggleCollapse(this.props.element.id);
  }

  render() {
    const element = this.props.element;
    const fields = fieldsStore.getChildren('element', this.props.element.id);
    return (
      <li className={element.collapse === true ? [modalStyles.modalMd, controlStyles.isHidden].join(' ') : [modalStyles.modalMd, controlStyles.isVisible].join(' ')}>
        <div className={titlebarStyles.elementTitlebar}>
          <p className={titlebarStyles.title}>{this.props.element.name}</p>
          <ModalControls
            isSection={false}
            closeModal={this.deleteModal.bind(this)}
            accordionControl={() => {this.accordionControl()}} />
        </div>
        <div className={controlStyles.fieldInput}>
          <label>
            Field Type
            <select onChange={function(e) {this.updateFieldType(e)}.bind(this)}>
              <option value="">Field Type</option>
              <option value="Text">Text</option>
              <option value="TextArea">Text Area</option>
              <option value="ColorPicker">Color Picker</option>
              <option value="ImageUpload">Image Upload</option>
            </select>
            <button
              className={[(this.state.ready() === true ? '' : controlStyles.disabled), btnStyles.btn].join(' ')}
              onClick={this.addField.bind(this)}>+</button>
          </label>
        </div>
        {fields.map((field) => {
          return (
            <BuilderField
              key={field.id}
              id={field.id}
              field={field} />
          );
        })}
      </li>
    );
  }
}

BuilderElement.propTypes = {
  element: React.PropTypes.object.isRequired,
}

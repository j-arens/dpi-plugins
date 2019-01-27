import React from 'react';

// stores
import elementsStore from '../stores/ElementsStore';
import fieldsStore from '../stores/FieldsStore';

// components
import OptionsElement from './OptionsElement';

// styles
import optionsStyles from '../styles/_options-page.css';

export default class OptionsComponent extends React.Component {
  constructor(props) {
    super(props);
    this.update = this.update.bind(this);
    this.state = {
      fields: fieldsStore.getAll()
    }
  }

  componentWillMount() {
    fieldsStore.on('fieldAdded', this.update);
  }

  componentWillUnmount() {
    fieldsStore.removeListener('fieldAdded', this.update);
  }

  update() {
    this.setState({
      fields: fieldsStore.getAll()
    });
  }

  render() {
    const elements = elementsStore.getChildren('component', this.props.component.id);
    if (this.props.currentComponent === this.props.component.id) {
      if (elements.length) {
        return (
          <div className={optionsStyles.optionsContainer}>
            {elements.map((element) => {
              return (
                <OptionsElement key={element.id} element={element} fields={this.state.fields} />
              );
            })}
          </div>
        );
      } else {
        return (
          <div className={optionsStyles.noContent}>No options to display yet.</div>
        );
      }
    } else {
      return false;
    }
  }
}

OptionsComponent.propTypes = {
  section: React.PropTypes.number.isRequired,
  component: React.PropTypes.object.isRequired,
  index: React.PropTypes.number.isRequired,
  currentComponent: React.PropTypes.number.isRequired,
}

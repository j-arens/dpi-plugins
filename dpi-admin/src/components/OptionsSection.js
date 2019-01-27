import React from 'react';

// stores
import elementsStore from '../stores/ElementsStore';
import componentsStore from '../stores/ComponentsStore';
import fieldsStore from '../stores/FieldsStore';

// components
import OptionsNav from './OptionsNav';
import OptionsComponent from './OptionsComponent';

// styles
import layoutStyle from '../styles/_layout.css';

export default class OptionsSection extends React.Component {
  constructor(props) {
    super(props);
    this.update = this.update.bind(this);
    this.state = {
      id: props.section,
      currentComponent: props.section,
      elements: elementsStore.getAll()
    }
  }

  componentWillReceiveProps(nextProps) {
    if (nextProps.section && (this.state.id !== nextProps.section.id)) {
      this.setState({
        id: nextProps.section,
        currentComponent: componentsStore.getChildren(nextProps.section)[0].id,
      });
    }
  }

  componentWillMount() {
    fieldsStore.on('fieldUpdated', this.update);
    elementsStore.on('elementAdded', this.update);
  }

  componentWillUnmount() {
    fieldsStore.removeListener('fieldUpdated', this.update);
    elementsStore.removeListener('elementAdded', this.update);
  }

  update() {
    this.setState({
      id: this.props.section,
      elements: elementsStore.getAll()
    });
  }

  changeComponent(id) {
    if (this.state.currentComponent === id) {
      return;
    } else {
      this.setState({
        currentComponent: id,
      });
    }
  }

  render() {
    const components = componentsStore.getChildren(this.state.id);
    return (
      <div className={layoutStyle.innerContainer}>
        <OptionsNav section={this.props.section} changeComponent={this.changeComponent.bind(this)} />
        {components.map((component, i) => {
          return (
            <OptionsComponent
              currentComponent={this.state.currentComponent}
              section={this.state.id}
              component={component}
              elements={this.state.elements}
              index={i}
              key={component.id} />
          );
        })}
      </div>
    );
  }
}

OptionsSection.propTypes = {
  section: React.PropTypes.number.isRequired,
}

import React from 'react';

import componentsStore from '../stores/ComponentsStore';

// components
import Builder from '../pages/Builder';
import OptionsSection from './OptionsSection';

export default class InnerContainer extends React.Component {
  constructor() {
    super();
    this.update = this.update.bind(this);
    this.state = {
      components: componentsStore.getAll()
    }
  }

  componentWillMount() {
    componentsStore.on('componentAdded', this.update);
  }

  componentWillUnmount() {
    componentsStore.removeListener('componentAdded', this.update);
  }

  update() {
    this.setState({
      components: componentsStore.getAll(),
    });
  }

  render() {
    switch (this.props.currentPage) {
      case 1:
        return <Builder />
      default:
        return <OptionsSection section={this.props.currentPage} components={this.state.components} />
    }
  }
}

InnerContainer.propTypes = {
  currentPage: React.PropTypes.number.isRequired,
}

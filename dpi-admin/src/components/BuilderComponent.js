import React from 'react';

// stores
import componentsStore from '../stores/ComponentsStore';
import elementsStore from '../stores/ElementsStore';

// actions
import * as ComponentActions from '../actions/ComponentActions';
import * as ElementActions from '../actions/ElementActions';

// components
import ModalControls from './ModalControls';
import BuilderElement from './BuilderElement';

// styles
import modalStyles from '../styles/_modals.css';
import titlebarStyles from '../styles/_titlebars.css';
import controlStyles from '../styles/_controls.css';
import btnStyles from '../styles/_buttons.css';

export default class BuilderComponent extends React.Component {
  constructor(props) {
    super(props);

    this.updateElements = this.updateElements.bind(this);

    this.state = {
      ready: function() {
        if (this.newElement.length) {
          return true;
        } else {
          return false;
        }
      },
      newElement: '',
      elements: elementsStore.getChildren('component', props.id),
      component: componentsStore.getComponent(props.id),
    }
  }

  componentWillMount() {
    elementsStore.on('elementAdded', this.updateElements);
    elementsStore.on('elementRemoved', this.updateElements);
  }

  componentWillUnmount() {
    elementsStore.removeListener('elementAdded', this.updateElements);
    elementsStore.removeListener('elementRemoved', this.updateElements);
  }

  isValid(str) {
    const regex = /^$|[a-zA-Z\d\@#!.$%="'()&-_\[/\]/\s]+/g;
    return regex.test(str);
  }

  updateName(e) {
    if (this.isValid(e.target.value)) {
      this.setState({
        newElement: e.target.value,
      });
    }
  }

  addElement() {
    ElementActions.createElement(this.props.component.section, this.props.id, this.state.newElement);
    this.setState({
      newElement: '',
    });
  }

  deleteModal() {
    ComponentActions.deleteComponent(this.props.id);
  }

  updateElements() {
    this.setState({
      elements: elementsStore.getChildren('component', this.props.id),
    });
  }

  accordionControl() {
    componentsStore.toggleCollapse(this.props.id);
  }

  render() {
    const component = this.state.component;
    return (
      <li className={component.collapse === true ? [modalStyles.modalLg, controlStyles.isHidden].join(' ') : [modalStyles.modalLg, controlStyles.isVisible].join(' ')}>
        <div className={titlebarStyles.componentTitlebar}>
          <p className={titlebarStyles.title}>{this.props.component.name}</p>
          <ModalControls
            isSection={false}
            closeModal={this.deleteModal.bind(this)}
            accordionControl={() => {this.accordionControl()}} />
        </div>
        <div className={controlStyles.fieldInput}>
          <label>
            Elements
            <input onChange={function(e) {this.updateName(e)}.bind(this)} value={this.state.newElement} type="text" />
            <button
              className={[(this.state.ready() === true ? '' : controlStyles.disabled), btnStyles.btn].join(' ')}
              onClick={this.addElement.bind(this)}>+</button>
          </label>
        </div>
        <ul className="elements">
          {this.state.elements.map((element, i) => {
            return (
              <BuilderElement
                key={element.id}
                element={element} />
            );
          })}
        </ul>
      </li>
    );
  }
}

BuilderComponent.propTypes = {
  component: React.PropTypes.object.isRequired,
  id: React.PropTypes.number.isRequired,
}

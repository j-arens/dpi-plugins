import React from 'react';

// actions
import * as ComponentActions from '../actions/ComponentActions';

// components
import CreatorControls from './CreatorControls';

// styles
import compCreatorStyles from '../styles/_component-creator.css';
import buttonStyles from '../styles/_buttons.css';

export default class ComponentCreator extends React.Component {
  constructor() {
    super();

    this.state = {
      ready: function() {
        if (this.name.length) {
          return true;
        } else {
          return false;
        }
      },
      name: '',
    };
  }

  isValid(str) {
    const regex = /^$|[a-zA-Z\d\@#!.$%="'()&-_\[/\]/\s]+/g;
    return regex.test(str);
  }

  updateName(e) {
    if(!e) {
      return false;
    } else {
      if (this.isValid(e.target.value)) {
        this.setState({
          name: e.target.value,
        });
      }
    }
  }

  addComponent() {
    ComponentActions.createComponent(this.props.section, this.state.name);
    this.closeModal();
  }

  closeModal() {
    this.props.closeCreator();
  }

  render() {
    return (
      <div id={compCreatorStyles.componentCreatorOverlay}>
        <div id={compCreatorStyles.componentCreator}>
          <div className={compCreatorStyles.componentCreatorTitlebar}>
            <h4 className={compCreatorStyles.title}>New Component</h4>
            <CreatorControls closeModal={this.closeModal.bind(this)} />
          </div>
          <ul className={compCreatorStyles.modalcontainer}>
            <li className={[compCreatorStyles.modalLg]}>
              <div className={compCreatorStyles.fieldInput}>
                <label>
                  Name
                  <input value={this.state.newComponent} onChange={(e) => {this.updateName(e)}} type="text" />
                </label>
              </div>
            </li>
            <li className={[compCreatorStyles.modalLg]}>
              <button
                className={[(this.state.ready() === true ? '' : compCreatorStyles.disabled), buttonStyles.btnRg, buttonStyles.success].join(' ')}
                onClick={this.addComponent.bind(this)}>Add Component</button>
            </li>
          </ul>
        </div>
      </div>
    );
  }
}

ComponentCreator.propTypes = {
  section: React.PropTypes.number.isRequired,
  closeCreator: React.PropTypes.func,
}

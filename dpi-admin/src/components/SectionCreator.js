import React from 'react';

// actions
import * as SectionActions from '../actions/SectionActions';
import * as ComponentActions from '../actions/ComponentActions';

// stores
import idStore from '../stores/IdStore';

// components
import CreatorControls from './CreatorControls';

// icons
import DeleteXIcon from '../icons/DeleteX';

// styles
import sectionCreatorStyles from '../styles/_section-creator.css';
import buttonStyles from '../styles/_buttons.css';

export default class SectionCreator extends React.Component {
  constructor() {
    super();

    this.state = {
      ready: function() {
        if (this.name.length && this.components.length) {
          return true;
        } else {
          return false;
        }
      },
      name: '',
      newComponent: '',
      components: [],
    };
  }

  isValid(str) {
    const regex = /^$|[a-zA-Z\d\@#!.$%="'()&-_\[/\]/\s]+/g;
    return regex.test(str);
  }

  updateName(e) {
    if(this.isValid(e.target.value)) {
      this.setState({
        name: e.target.value,
      });
    }
  }

  updateComponent(e) {
    if (this.isValid(e.target.value)) {
      this.setState({
        newComponent: e.target.value,
      });
    }
  }

  addComponent() {
    const newComponent = this.state.newComponent;
    let components = this.state.components;
    components.push(newComponent);

    this.setState({
      newComponent: '',
      components: components,
    });
  }

  removeComponent(component) {
    let components = this.state.components;
    const index = components.indexOf(component);
    components.splice(index, 1);

    this.setState({
      components: components,
    });
  }

  createSection() {
    const id = idStore.createId();

    SectionActions.createSection(id, this.state.name);

    this.state.components.forEach((component) => {
      ComponentActions.createComponent(id, component);
    });

    this.closeModal();
  }

  closeModal() {
    this.props.showCreator(false);
  }

  render() {
    return (
      <div id={sectionCreatorStyles.sectionCreatorOverlay}>
        <div id={sectionCreatorStyles.sectionCreator}>
          <div className={sectionCreatorStyles.sectionCreatorTitlebar}>
            <h4 className={sectionCreatorStyles.title}>New Section</h4>
            <CreatorControls closeModal={this.closeModal.bind(this)} />
          </div>
          <ul className={sectionCreatorStyles.modalcontainer}>
            <li className={[sectionCreatorStyles.modalLg]}>
              <div className={sectionCreatorStyles.fieldInput}>
                <label>
                  Section Title
                  <input value={this.state.sectionName} onChange={(e) => {this.updateName(e)}} type="text" />
                </label>
              </div>
            </li>
            <li className={[sectionCreatorStyles.modalLg]}>
              <div className={sectionCreatorStyles.fieldInput}>
                <label>
                  Components
                  <input value={this.state.newComponent} onChange={(e) => {this.updateComponent(e)}} type="text" />
                  <button onClick={this.addComponent.bind(this)} className={[(this.state.newComponent.length > 0 ? '' : sectionCreatorStyles.disabled), sectionCreatorStyles.btn, sectionCreatorStyles.add].join(' ')}>+</button>
                </label>
              </div>
            </li>
            <li className={[sectionCreatorStyles.modalLg]}>
              <p><strong>{this.state.name}</strong></p>
              {this.state.components.map((component, i) => {
                return (
                  <p key={i}>- {component} <button onClick={() => this.removeComponent(component)} className={sectionCreatorStyles.deleteBtn}><DeleteXIcon /></button></p>
                );
              })}
            </li>
            <li className={[sectionCreatorStyles.modalLg]}>
              <button
                className={[(this.state.ready() === true ? '' : sectionCreatorStyles.disabled), buttonStyles.btnRg, buttonStyles.success].join(' ')}
                onClick={this.createSection.bind(this)}>Create Section</button>
            </li>
          </ul>
        </div>
      </div>
    );
  };
}

SectionCreator.propTypes = {
  showCreator: React.PropTypes.func,
}

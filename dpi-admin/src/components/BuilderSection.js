import React from 'react';
import Masonry from 'react-masonry-component';

// stores
import sectionsStore from '../stores/SectionsStore';
import componentsStore from '../stores/ComponentsStore';
import elementsStore from '../stores/ElementsStore';
import fieldsStore from '../stores/FieldsStore';

// actions
import * as SectionActions from '../actions/SectionActions';

// components
import ModalControls from './ModalControls';
import BuilderComponent from './BuilderComponent';
import ComponentCreator from './ComponentCreator';

// styles
import titlebarStyles from '../styles/_titlebars.css';
import modalStyles from '../styles/_modals.css';
import controlStyles from '../styles/_controls.css';

export default class BuilderSection extends React.Component {
  constructor(props) {
    super(props);

    this.componentRemoved = this.componentRemoved.bind(this);
    this.updateComponents = this.updateComponents.bind(this);
    this.reloadMasonry = this.reloadMasonry.bind(this);

    this.state = {
      showCreator: false,
      components: componentsStore.getChildren(props.id),
      section: sectionsStore.getSection(props.id),
    };
  }

  componentWillMount() {
    componentsStore.on('componentRemoved', this.componentRemoved);
    componentsStore.on('componentAdded', this.updateComponents);
    elementsStore.on('elementAdded', this.reloadMasonry);
    elementsStore.on('elementRemoved', this.reloadMasonry);
    fieldsStore.on('fieldAdded', this.reloadMasonry);
    fieldsStore.on('fieldRemoved', this.reloadMasonry);
    sectionsStore.on('masonryReload', this.reloadMasonry);
    componentsStore.on('masonryReload', this.reloadMasonry);
    elementsStore.on('masonryReload', this.reloadMasonry);
    fieldsStore.on('masonryReload', this.reloadMasonry);
  }

  componentWillUnmount() {
    componentsStore.removeListener('componentRemoved', this.componentRemoved);
    componentsStore.removeListener('componentAdded', this.updateComponents);
    elementsStore.removeListener('elementAdded', this.reloadMasonry);
    elementsStore.removeListener('elementRemoved', this.reloadMasonry);
    fieldsStore.removeListener('fieldAdded', this.reloadMasonry);
    fieldsStore.removeListener('fieldRemoved', this.reloadMasonry);
    sectionsStore.removeListener('masonryReload', this.reloadMasonry);
    componentsStore.removeListener('masonryReload', this.reloadMasonry);
    elementsStore.removeListener('masonryReload', this.reloadMasonry);
    fieldsStore.removeListener('masonryReload', this.reloadMasonry);
  }

  reloadMasonry() {
    this.forceUpdate();
  }

  componentRemoved() {
    this.setState({
      components: componentsStore.getChildren(this.props.id),
    });
  }

  removeSection() {
    SectionActions.deleteSection(this.props.id);
  }

  addComponent() {
    this.setState({
      showCreator: true,
    });
  }

  updateComponents() {
    this.setState({
      components: componentsStore.getChildren(this.props.id),
    });
  }

  closeCreator() {
    this.setState({
      showCreator: false,
    });
  }

  accordionControl() {
    sectionsStore.toggleCollapse(this.props.id);
  }

  render() {
    const section = this.state.section;
    return (
      <li id={this.props.name} className={section.collapse === true ? [modalStyles.modalSection, controlStyles.isHidden].join(' ') : [modalStyles.modalSection, controlStyles.isVisible].join(' ')}>
      {this.state.showCreator === true ? <ComponentCreator closeCreator={this.closeCreator.bind(this)} section={this.props.id} /> : ''}
        <div className={titlebarStyles.sectionTitlebar}>
          <h4 className={titlebarStyles.title}>{this.props.name}</h4>
          <ModalControls
            option={this.addComponent.bind(this)}
            isSection={true}
            closeModal={() => {this.removeSection(false)}}
            accordionControl={() => {this.accordionControl()}} />
        </div>
        <Masonry
          className={modalStyles.modalcontainer}
          elementType={'ul'}>
          {this.state.components.map((component) => {
            if (component.section === this.props.id) {
              return (
                <BuilderComponent
                  key={component.id}
                  id={component.id}
                  component={component} />
              );
            } else {
              return false;
            }
          })}
        </Masonry>
      </li>
    );
  }
}

BuilderSection.propTypes = {
  name: React.PropTypes.string.isRequired,
  id: React.PropTypes.number.isRequired,
}

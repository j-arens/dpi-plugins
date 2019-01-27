import React from 'react';

// stores
import SectionsStore from '../stores/SectionsStore';

// components
import TopNav from '../components/TopNav';
import SectionCreator from '../components/SectionCreator';
import BuilderSection from '../components/BuilderSection';

// styles
import style from '../styles/_layout.css';
import builderStyle from '../styles/_builder-page.css';
import modalStyles from '../styles/_modals.css';

export default class Builder extends React.Component {
  constructor() {
    super();

    this.sectionAdded = this.sectionAdded.bind(this);
    this.sectionRemoved = this.sectionRemoved.bind(this);

    this.state = {
      showCreator: false,
      hasContent: function() {
        if (this.sections.length > 0) {
          return true;
        } else {
          return false;
        }
      },
      sections: SectionsStore.getAll(),
      actionLinks: [{ icon: 'collectionPlus', name: 'Create Section' }],
    }
  }

  componentWillMount() {
    SectionsStore.on('sectionAdded', this.sectionAdded);
    SectionsStore.on('sectionRemoved', this.sectionRemoved);
  }

  componentWillUnmount() {
    SectionsStore.removeListener('sectionAdded', this.sectionAdded);
    SectionsStore.removeListener('sectionRemoved', this.sectionRemoved);
  }

  showCreator(delta) {
    this.setState({
      showCreator: delta,
    });
  }

  sectionAdded() {
    this.setState({
      sections: SectionsStore.getAll(),
    });
  }

  sectionRemoved() {
    this.setState({
      sections: SectionsStore.getAll(),
    });
  }

  render() {
    return (
      <div id="builder" className={style.innerContainer}>
      <TopNav title="Builder" links={this.state.actionLinks} showCreator={this.showCreator.bind(this)} />
      {this.state.showCreator === false ? '' : <SectionCreator showCreator={this.showCreator.bind(this)}/>}
      {this.state.hasContent() === false ? <div className={builderStyle.noContent}>Create a new section by clicking on the create section button above.</div> : <ul className={modalStyles.outerContainer}> {this.state.sections.map((section) => {
        return (
          <BuilderSection key={section.id} id={section.id} name={section.name} />
          );
        })}</ul>}
      </div>
    );
  }
}

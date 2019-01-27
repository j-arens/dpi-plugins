import React from 'react';

// components
import TopNav from '../components/TopNav.js';

// styles
import style from '../styles/_layout.css';
import settingsStyles from '../styles/_settings-page.css';

export default class Settings extends React.Component {
  constructor() {
    super();

    this.state = {
      hasContent: false,
      actionLinks: [{ icon: 'collectionPlus', name: 'Link 1' }],
    }
  }

  render() {
    return (
      <div className={style.innerContainer}>
      <TopNav title="Settings" links={this.state.actionLinks}/>
        <div className={settingsStyles.noContent}>This is the settings page.</div>
      </div>
    );
  }
}

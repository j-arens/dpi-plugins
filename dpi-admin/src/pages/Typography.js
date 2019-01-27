import React from 'react';

// components
import TopNav from '../components/TopNav.js';

// styles
import style from '../styles/_layout.css';
import typographyStyle from '../styles/_typography-page.css';

export default class Typography extends React.Component {
  constructor() {
    super();

    this.state = {
      hasContent: false,
      actionLinks: [{ icon: 'collectionPlus', name: 'Font Option 1' }],
    }
  }
  render() {
    return (
      <div className={style.innerContainer}>
      <TopNav title="Typography" links={this.state.actionLinks} />
        <div className={typographyStyle.noContent}>This is the typography page.</div>
      </div>
    );
  }
}

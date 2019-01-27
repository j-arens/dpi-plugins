import React from 'react';

// components
import TopNav from '../components/TopNav.js';

// styles
import style from '../styles/_layout.css';

export default class Header extends React.Component {
  constructor() {
    super();

    this.state = {
      hasContent: false,
      actionLinks: [{ icon: 'collectionPlus', name: 'Rename Me' }],
    }
  }

  render() {
    return (
      <div className={style.innerContainer}>
      <TopNav title="Header" links={this.state.actionLinks} />
      </div>
    );
  }
}

import React from 'react';

// components
import TopNav from '../components/TopNav.js';

// styles
import style from '../styles/_layout.css';
import colorsStyles from '../styles/_colors-page.css';

export default class Builder extends React.Component {
  constructor() {
    super();

    this.state = {
      hasContent: false,
      actionLinks: [{ icon: 'collectionPlus', name: 'Action Link' }],
    }
  }
  render() {
    return (
      <div className={style.innerContainer}>
      <TopNav title="Colors" links={this.state.actionLinks} />
        <div className={colorsStyles.noContent}>This is the colors page.</div>
      </div>
    );
  }
}

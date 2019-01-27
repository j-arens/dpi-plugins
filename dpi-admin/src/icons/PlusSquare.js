import React from 'react';

// styles
import style from '../styles/_controls.css';

export default class PlusSquareIcon extends React.Component {
  render() {
    return (
      <svg className={style.addIcon} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg>
    );
  }
}
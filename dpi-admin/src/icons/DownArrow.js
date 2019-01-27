import React from 'react';

// styles
import style from '../styles/_controls.css';

export default class DownArrowIcon extends React.Component {
  render() {
    return (
      <svg className={style.downArrowIcon} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 480 480"><path d="M240 40C129.6 40 40 129.6 40 240 40 350.4 129.6 440 240 440 350.4 440 440 350.4 440 240 440 129.6 350.4 40 240 40Zm-100 160 200 0-100 100z"/></svg>
    );
  }
}

import React from 'react';

// styles
import style from '../styles/_side-nav.css';

// icons
import SideNavIcon from '../icons/SideNavIcons';

export default class PageLink extends React.Component {
  handleClick() {
    this.props.handleClick();
  }

  render() {
    return (
      <li
        onClick={this.handleClick.bind(this)}
        className={this.props.currentPage === this.props.id ? style.active : ''}>
          <SideNavIcon id={this.props.id} />
          {this.props.name}
        </li>
    );
  }
}

PageLink.propTypes = {
  name: React.PropTypes.string.isRequired,
  handleClick: React.PropTypes.func.isRequired,
  currentPage: React.PropTypes.number.isRequired,
  id: React.PropTypes.number.isRequired,
}

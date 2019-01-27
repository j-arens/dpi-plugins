import React from 'react';

// icons
import TopNavIcon from '../icons/TopNavIcons';

export default class ActionLink extends React.Component {
  handleClick() {
    this.props.handleClick();
  }

  render() {
    return (
      <li onClick={this.handleClick.bind(this)}><TopNavIcon icon={this.props.icon} />{this.props.name}</li>
    );
  }
}

ActionLink.propTypes = {
  name: React.PropTypes.string.isRequired,
  icon: React.PropTypes.string.isRequired,
  handleClick: React.PropTypes.func,
}

import React from 'react';

// styles
// import style from '../styles/_side-nav.css';

// icons
import EditIcon from '../icons/Edit';

export default class ComponentLink extends React.Component {
  handleClick() {
    this.props.handleClick(this.props.component.id);
  }

  render() {
    return (
      <li onClick={this.handleClick.bind(this)}>
        <EditIcon />
        {this.props.name}
      </li>
    );
  }
}

ComponentLink.propTypes = {
  handleClick: React.PropTypes.func,
  name: React.PropTypes.string.isRequired,
  component: React.PropTypes.object.isRequired,
}

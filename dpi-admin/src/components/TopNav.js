import React from 'react';

// actions
import * as AppActions from '../actions/AppActions';

// components
import ActionLink from './ActionLink';

// styles
import style from '../styles/_top-nav.css';
import buttonStyle from '../styles/_buttons.css';

export default class TopNav extends React.Component {
  handleClick(link) {
    switch (link.name) {
      case 'Create Section':
        this.props.showCreator(true);
        break;
      default:
          break;
    }
  }

  render() {
    return (
      <nav id={style.topNav}>
        <ul>
          {this.props.links.map((link, i) => {
            return (
              <ActionLink key={i} name={link.name} icon={link.icon} handleClick={this.handleClick.bind(this, link)} />
            );
          })}
        </ul>
        <button onClick={() => {AppActions.saveState()}} className={[buttonStyle.btnXlg, buttonStyle.success].join(' ')} id={style.submit}>Save Settings</button>
      </nav>
    );
  }
}

TopNav.propTypes = {
  title: React.PropTypes.string.isRequired,
  links: React.PropTypes.arrayOf(React.PropTypes.object),
  showCreator: React.PropTypes.func,
}

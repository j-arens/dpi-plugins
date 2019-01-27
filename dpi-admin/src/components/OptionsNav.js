import React from 'react';

// actions
import * as AppActions from '../actions/AppActions';

// stores
import componentsStore from '../stores/ComponentsStore';

// components
import ComponentLink from './ComponentLink';

// styles
import style from '../styles/_top-nav.css';
import buttonStyle from '../styles/_buttons.css';

export default class OptionsNav extends React.Component {
  handleClick(id) {
    this.props.changeComponent(id);
  }

  render() {
    const components = componentsStore.getChildren(this.props.section);
    return (
      <nav id={style.topNav}>
        <ul>
          {components.map((component, i) => {
            return (
              <ComponentLink
                key={component.id}
                index={i}
                component={component}
                name={component.name}
                handleClick={this.handleClick.bind(this)} />
            );
          })}
        </ul>
        <button onClick={() => {AppActions.saveState()}} className={[buttonStyle.btnXlg, buttonStyle.success].join(' ')} id={style.submit}>Save Settings</button>
      </nav>
    );
  }
}

OptionsNav.propTypes = {
  section: React.PropTypes.number.isRequired,
  changeComponent: React.PropTypes.func,
}

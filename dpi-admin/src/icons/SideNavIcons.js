import React from 'react';

// icons
import SettingsIcon from './Settings';
import WrenchIcon from './Wrench';
import BrushIcon from './Brush';
import FontIcon from './Font';
import CopyIcon from './Copy';

export default class SideNavIcon extends React.Component {
  render() {
    switch (this.props.id) {
      case 1:
        return <SettingsIcon />;
      case 2:
        return <WrenchIcon />;
      case 3:
        return <BrushIcon />;
      case 4:
        return <FontIcon />;
      default:
        return <CopyIcon />
    }
  }
}

SideNavIcon.propTypes = {
  id: React.PropTypes.number.isRequired,
}

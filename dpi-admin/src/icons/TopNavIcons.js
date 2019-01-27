import React from 'react';

// icons
import CollectionPlusIcon from './CollectionPlus';

export default class TopNavIcon extends React.Component {
  render() {
    switch (this.props.icon) {
      case 'collectionPlus':
        return <CollectionPlusIcon />;
      default:
        return <CollectionPlusIcon />
    }
  }
}

TopNavIcon.propTypes = {
  icon: React.PropTypes.string.isRequired,
}

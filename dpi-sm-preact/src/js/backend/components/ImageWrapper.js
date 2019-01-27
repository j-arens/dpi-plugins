import { h, render, Component } from 'preact';
import { connect } from 'preact-redux';
import * as actions from '../actions';
import model from '../model';

// components
import Image from './Image';
import ImagePicker from './ImagePicker';

const mapStateToProps = (model) => {
  return model.instances;
}

class ImageWrapper extends Component {
  renderInner(instance) {
    if (instance.hasImage) {
      console.log('has image: ', instance);
      return <Image instance={instance} />
    } else {
      return <ImagePicker instance={instance} />
    }
  }

  render({ id, Image }) {
    const instance = Image.filter(inst => inst.id === id)[0];
    return (
      <div class="column-image">
        {this.renderInner(instance)}
      </div>
    );
  }
}

export default connect(mapStateToProps.bind(model), actions)(ImageWrapper);

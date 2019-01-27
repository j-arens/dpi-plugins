import { h } from 'preact';
import { connect } from 'preact-redux';
import * as actions from '../actions';

// icons
import Upload from '../icons/Upload';

let ImagePicker = ({ instance, addImage }) => (
  <button
      onClick={(e) => {e.preventDefault(); window.dpiSuperMenu.mediaPicker(instance.id, addImage)}}
      class="image-picker"
    >
    {Upload()}
    <span class="uk-text-meta">Click to add an image.</span>
  </button>
);

ImagePicker = connect(null, actions)(ImagePicker);

export default ImagePicker;

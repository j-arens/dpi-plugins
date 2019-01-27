import React from 'react';

// actions
import * as FieldActions from '../actions/FieldActions';

// styles
import optionsPageStyles from '../styles/_options-page.css';
import btnStyles from '../styles/_buttons.css';

export default class OptionsImageUpload extends React.Component {
  selectImage(id) {

    if (!window.dpiMediaFrame) {
      window.dpiMediaFrame = window.wp.media({
        title: 'Select Image',
        button: { text: 'Select' },
        library: { type: 'image' },
        multiple: false,
      });

      window.dpiMediaFrame.on('select', function() {
        const uid = window.dpiMediaFrame.img_uid;
        const imgEl = document.getElementById(`img_${uid}`);
        const attachment = window.dpiMediaFrame.state().get('selection').first().toJSON();

        if (attachment) {
          FieldActions.updateField(uid, 'val', attachment.id);
          FieldActions.updateField(uid, 'img_url', attachment.url);
          imgEl.setAttribute('src', attachment.url);
        }
      });
    }

    window.dpiMediaFrame.img_uid = id;
    window.dpiMediaFrame.open();
    return false;
  }

  removeImage(id) {
    const imgEl = document.getElementById('img_' + id);

    // remove from fieldsstore
    FieldActions.updateField(id, 'val', '');
    FieldActions.updateField(id, 'img_url', '');

    // remove img src
    imgEl.setAttribute('src', '');
  }

  render() {
    const field = this.props.field;
    return (
      <div className={optionsPageStyles.option}>
        <p className={optionsPageStyles.fieldLabel}>{this.props.field.name.replace(/_/g, ' ')}<em>{field.desc.length > 0 ? '- ' + field.desc : ''}</em></p>
        <img id={'img_' + field.id} src={field.img_url} role="presentation" />
        <button onClick={() => {this.selectImage(field.id)}} className={btnStyles.btnRg}>Upload new image</button>
        <button onClick={() => {this.removeImage(field.id)}} className={btnStyles.btnRg}>Remove image</button>
      </div>
    );
  }
}

OptionsImageUpload.propTypes = {
  field: React.PropTypes.object.isRequired,
}

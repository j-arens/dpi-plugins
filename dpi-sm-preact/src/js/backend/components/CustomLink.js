import { h } from 'preact';
import { bindActionCreators } from 'redux';
import { connect } from 'preact-redux';
import * as actions from '../actions';
import model from '../model';

const mapStateToProps = (model) => {
  return model.customLink;
}

const mapDispatchToProps = (dispatch) => {
  return bindActionCreators(actions, dispatch);
}

let CustomLink = ({ url, targetBlank, changeLinkURL, changeTargetBlank }) => (
  <div class="dpi-sm-custom-link-options uk-animation-slide-bottom-small">
    <div class="uk-margin">
      <input
        value={url}
        type="text"
        onInput={(e) => {changeLinkURL(e.target.value)}}
        class="uk-input"
        placeholder="link URL"
      />
    </div>
    <div class="uk-form-controls">
      <label>
        <input
          value={targetBlank}
          onChange={() => {changeTargetBlank(true)}}
          type="radio"
          class="uk-radio"
        />
        Open Link In New Tab
      </label>
    </div>
  </div>
);

CustomLink = connect(mapStateToProps.bind(model), mapDispatchToProps)(CustomLink);

export default CustomLink;

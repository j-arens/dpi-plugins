import { h } from 'preact';
import { connect } from 'preact-redux';
import * as actions from '../actions';

// icons
import LeftArrow from '../icons/LeftArrow';

let ColumnTypeSelector = ({ id, type, changeColumnInstance }) => (
  <div class="uk-panel ColumnTypeSelector">
    <button
      class="uk-button uk-button-text back-button"
      onClick={(e) => {e.preventDefault(); console.log('back button', type); changeColumnInstance(id, type)}}
    >
    {LeftArrow()} Back
    </button>
    <h5 class="uk-heading-divider">Column Type</h5>
    <div class="uk-form-controls">
      <label>
        <input
          class="uk-radio"
          type="radio"
          name={'columnType' + id}
          value="Blank"
          onChange={() => {changeColumnInstance(id, 'Blank')}}
        />
        Blank
      </label>
      <label>
        <input
          class="uk-radio"
          type="radio"
          name={'columnType' + id}
          value="Image"
          onChange={() => {changeColumnInstance(id, 'Image')}}
        />
        Image
      </label>
      <label>
        <input
          class="uk-radio"
          type="radio"
          name={'columnType' + id}
          value="SubMenu"
        />
        Sub Menu
      </label>
      <label>
        <input
          class="uk-radio"
          type="radio"
          name={'columnType' + id}
          value="Search"
        />
        Search
      </label>
      <label>
        <input
          class="uk-radio"
          type="radio"
          name={'columnType' + id}
          value="Shortcode"
        />
        Shortcode
      </label>
      <label>
        <input
          class="uk-radio"
          type="radio"
          name={'columnType' + id}
          value="RawHTML"
        />
        Raw HTML
      </label>
    </div>
  </div>
);

ColumnTypeSelector = connect(null, actions)(ColumnTypeSelector);

export default ColumnTypeSelector;

import { h } from 'preact';

// components
import CustomLink from './CustomLink';
import CustomSection from './CustomSection';

const renderOptions = (type) => {
  if (type === 'customLink') {
    return <CustomLink />;
  } else if (type === 'customSection') {
    return <CustomSection />
  }
}

const Main = ({ name, type, changeItemName, changeItemType }) => (
  <div class="dpi-sm-inside">
    <div class="itemType">
      <fieldset class="uk-fieldset">
        <legend class="uk-legend">{name ? `Menu Item - ${name}` : 'New Menu Item'}</legend>
        <div class="uk-margin">
          <input
            value={name}
            onInput={(e) => {changeItemName(e.target.value)}}
            class="uk-input"
            type="text"
            placeholder="Menu Item Name"
          />
        </div>
        <div class="dpi-sm-menu-item-type">
          <div class="uk-form-label uk-margin-bottom">Menu Item Type</div>
          <div class="uk-form-controls">
            <label>
              <input
                type="radio"
                checked={type === 'customLink'}
                onChange={() => {changeItemType('customLink')}}
                value="customLink"
                class="uk-radio"
                name="itemType"
              />
              Custom Link
            </label>
            <label>
              <input
                type="radio"
                checked={type === 'customSection'}
                onChange={() => {changeItemType('customSection')}}
                value="customSection"
                class="uk-radio"
                name="itemType"
              />
              Custom Section
            </label>
          </div>
        </div>
      </fieldset>
    </div>
    <hr/>
    <div class="menuItemType-root">
      {renderOptions(type)}
    </div>
  </div>
);

export default Main;

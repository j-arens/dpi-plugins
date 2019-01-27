import LeftArrow from '../icons/LeftArrow';

export default class ColumnTypeSelector {
  constructor(props) {
    this.props = props;
  }

  dismount() {
    const node = window.dpiSuperMenu.root().querySelector(`[data-column-id="${this.id}"] .ColumnTypeSelector`);
    window.dpiSuperMenu.root().querySelector(`[data-column-id="${this.id}"]`).removeChild(node);
  }

  render() {
    const template = `
      <div class="uk-panel ColumnTypeSelector">
        <button
          onclick="(function() {
            this.event.preventDefault();
            window.dpiSuperMenu.deleteInstance('ColumnTypeSelector', ${this.id});
          })()"
          class="uk-button uk-button-text back-button">
          ${LeftArrow()}
          <h5>Back</h5>
        </button>
        <h5 class="uk-heading-divider">Column Type</h5>
        <div class="uk-form-controls">
          <label>
            <input
              onchange="(function() {

              })()"
              class="uk-radio" type="radio" name="columnType"> Blank
          </label>
          <label>
            <input
              onchange="(function() {console.log('columnType Image')})()"
              class="uk-radio" type="radio" name="columnType"> Image
          </label>
          <label>
            <input
              onchage="(function() {console.log('columnType Sub Menu')})()"
              class="uk-radio" type="radio" name="columnType"> Sub Menu
          </label>
          <label>
            <input
              onchange="(function() {console.log('ColumnType Search')})()"
              class="uk-radio" type="radio" name="columnType"> Search
          </label>
          <label>
            <input
              onchange="(function() {console.log('columnType Shortcode')})()"
              class="uk-radio" type="radio" name="columnType"> Shortcode
          </label>
          <label>
            <input
              onchange="(function() {console.log('columnType Raw HTML')})()"
              class="uk-radio" type="radio" name="columnType"> Raw HTML
          </label>
        </div>
      </div>
    `;
    const html = document.createRange().createContextualFragment(template);
    window.dpiSuperMenu.root().querySelector(`.drag-column[data-column-id="${this.id}"]`).appendChild(html);
  }
}

export default class CustomLink {
  constructor(props) {
    this.props = props;
  }

  render() {
    return `
      <div class="dpi-sm-custom-link-options uk-animation-slide-bottom-small">
        <div class="uk-margin">
          <input
            oninput="(function() {window.dpiSuperMenu.update({prop: 'linkName', delta: this.value})}.bind(this))()"
            value="${this.props.linkName}"
            class="uk-input"
            type="text"
            placeholder="Link URL">
        </div>
        <div class="uk-form-controls">
          <label>
            <input
              onchange="(function() {window.dpiSuperMenu.update({prop: 'targetBlank', delta: this.value})}.bind(this))()"
              ${this.props.targetBlank ? 'checked' : ''}
              class="uk-radio"
              type="radio">
            Open Link In New Tab
          </label>
        </div>
      </div>
    `;
  }
}

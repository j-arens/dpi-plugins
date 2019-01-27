export default class CustomSection {
  constructor(props) {
    this.props = props;
  }

  render() {
    return `
      <div class="dpi-sm-custom-section-options uk-animation-slide-bottom-small">
        ${window.dpiSuperMenu.component('EditorControls', {})}
        <div class="uk-card uk-card-default uk-background-muted">
          ${window.dpiSuperMenu.component('ModelNav', window.dpiSuperMenu.getProps('ModelNav'))}
        </div>
      </div>
    `;
  }
}

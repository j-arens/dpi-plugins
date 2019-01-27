export default class EditorControls {
  constructor(props) {
    this.props = props;
  }

  render() {
    return `
      <section class="uk-margin-bottom">
        <div class="uk-button-group">
          <button
            onclick="(function() {
              this.event.preventDefault();
              window.dpiSuperMenu.update({prop: 'newColumn', type: 'Blank'});
            })()"
            class="uk-button uk-button-primary">+ Add A Column</button>
          <button
            onclick="(function() {
              this.event.preventDefault();
              window.dpiSuperMenu.saveState();
            })()"
            class="uk-button uk-button-default">Option</button>
        </div>
        <button
          onclick="(function() {
            this.event.preventDefault();
            console.log('reset clicked');
          })()"
          class="uk-button uk-button-danger uk-align-right">Reset</button>
      </section>
    `;
  }
}

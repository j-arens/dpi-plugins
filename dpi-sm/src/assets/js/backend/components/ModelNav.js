export default class ModelNav {
  constructor(props) {
    this.props = props;
  }

  render() {
    return `
      <div class="uk-position-relative">
        <nav class="uk-navbar-container">
          <ul class="uk-navbar-nav">
            ${this.props.navItems.map((item) => {
              return `
                <li>
                  <a href="#">${item}</a>
                </li>
              `;
            }).join('')}
          </ul>
        </nav>
        <div id="DropBar-root">
          ${window.dpiSuperMenu.component('DropBar', window.dpiSuperMenu.getProps('DropBar'))}
        </div>
      </div>
    `;
  }
}

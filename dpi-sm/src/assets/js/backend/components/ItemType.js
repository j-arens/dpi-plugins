export default class ItemType {
  constructor(props) {
    this.render(props);
    this.bindEvents();
  }

  bindEvents() {
    this.menuItemNameChangedToken = window.dpiSuperMenu.events.on('menuItemName_changed', this.updateLegendTitle.bind(this));
    this.menuItemTypChangedToken = window.dpiSuperMenu.events.on('menuItemType_changed', this.updateMenuItemType.bind(this));
  }

  dismount() {
    window.dpiSuperMenu.events.off('menuItemName_changed', this.menuItemNameChangedToken);
    window.dpiSuperMenu.events.off('menuItemName_changed', this.menuItemTypChangedToken);
  }

  updateLegendTitle() {
    const legendTitle = window.dpiSuperMenu.getProps('ItemType').menuItemName;
    window.dpiSuperMenu.root().querySelector('.ItemType .uk-legend').textContent = legendTitle ? `Menu Item - ${legendTitle}` : 'New Menu Item';
  }

  updateMenuItemType() {
    this.props = window.dpiSuperMenu.getProps('ItemType');
    window.dpiSuperMenu.root().querySelector('#menuItemType-root').innerHTML = window.dpiSuperMenu.component(this.props.menuItemType, window.dpiSuperMenu.getProps(this.props.menuItemType));
  }

  renderItemType(props) {
    const root = window.dpiSuperMenu.root().querySelector('#menuItemType-root');
    if (props.menuItemType) {
      root.innerHTML = window.dpiSuperMenu.component(props.menuItemType, window.dpiSuperMenu.getProps(props.menuItemType));
    }
  }

  render(props) {
    const template = `
      <div class="ItemType">
        <fieldset class="uk-fieldset">
          <legend class="uk-legend">${props.menuItemName ? props.menuItemName : 'New Menu Item'}</legend>
          <div class="uk-margin">
            <input
              oninput="(function() {window.dpiSuperMenu.update({prop: 'menuItemName', delta: this.value})}.bind(this))()"
              class="uk-input"
              type="text"
              placeholder="Menu Item Name"
              value="${props.menuItemName}">
          </div>
          <div class="dpi-sm-menu-item-type">
            <div class="uk-form-label uk-margin-bottom">Menu Item Type</div>
            <div class="uk-form-controls">
              <label>
                <input
                  onchange="(function() {window.dpiSuperMenu.update({prop: 'menuItemType', delta: 'CustomLink'})})()"
                  ${props.menuItemType === 'CustomLink' ? 'checked' : ''}
                  class="uk-radio"
                  type="radio"
                  name="itemType">
                Custom Link
              </label>
              <label>
                <input
                  onchange="(function() {window.dpiSuperMenu.update({prop: 'menuItemType', delta: 'CustomSection'})})()"
                  ${props.menuItemType === 'CustomSection' ? 'checked' : ''}
                  class="uk-radio"
                  type="radio"
                  name="itemType">
                Custom Section
              </label>
            </div>
          </div>
        </fieldset>
      </div>
      <hr>
      <div id="menuItemType-root"></div>
    `;

    window.dpiSuperMenu.root().querySelector(props.rootSelector).innerHTML = template;
    this.renderItemType(props);
  }
}

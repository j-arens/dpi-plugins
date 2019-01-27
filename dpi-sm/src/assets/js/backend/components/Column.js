export default class Column {
  constructor(props) {
    this.id = props.id;
    this.type = props.type;
    this.bindEvents();
  }

  bindEvents() {
    this.removeColumnTypeSelectorToken = window.dpiSuperMenu.events.on('ColumnTypeSelector_removed', this.removeColumnTypeSelector.bind(this));
  }

  dismount() {
    window.dpiSuperMenu.events.off('ColumnTypeSelector_removed', this.removeColumnTypeSelectorToken);
  }

  removeColumnTypeSelector(id) {
    if (this.id === id) {
      const column = window.dpiSuperMenu.root().querySelector(`.drag-column[data-column-id="${this.id}"]`);
      column.removeChild(column.querySelector('.ColumnTypeSelector'));
    }
  }

  render() {
    return `
      <section class="uk-placeholder drag-column" data-column-id="${this.id}">
        <div class="uk-sortable-handle">
          ${window.dpiSuperMenu.instance('ColumnControls', this.id)}
          ${window.dpiSuperMenu.instance(this.type, this.id)}
        </div>
      </section>
    `;
  }
}

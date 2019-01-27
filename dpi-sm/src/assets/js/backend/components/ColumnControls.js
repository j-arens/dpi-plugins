import Dropdown from '../icons/Dropdown';
import Drag from '../icons/Drag';
import Close from '../icons/Close';

export default class ColumnControls {
  constructor(props) {
    this.props = props;
    this.bindEvents();
  }

  bindEvents() {
    this.columnAddedToken = window.dpiSuperMenu.events.on('column_added', this.updateControls.bind(this));
    this.columnRemovedToken = window.dpiSuperMenu.events.on('column_removed', this.updateControls.bind(this));
  }

  dismount() {
    console.log('dismount column controls');
    window.dpiSuperMenu.events.off('column_added', this.columnAddedToken);
    window.dpiSuperMenu.events.off('column_removed', this.columnRemovedToken);
  }

  updateControls() {
    if (window.dpiSuperMenu.getProps('DropBar').count > 1) {
      window.dpiSuperMenu.root().querySelector(`[data-column-id="${this.id}"] .delete-button`).classList.remove('dpi-sm-button-disabled');
    } else {
      window.dpiSuperMenu.root().querySelector(`[data-column-id="${this.id}"] .delete-button`).classList.add('dpi-sm-button-disabled');
    }
  }

  render() {
    return `
      <div class="column-controls">
        <div class="uk-button-group">
          <button
            onclick="(function() {
              this.event.preventDefault();
              window.dpiSuperMenu.instance('ColumnTypeSelector', ${this.id})
            })()"
            class="uk-button uk-button-primary dropdown-button">
            ${Dropdown()}
          </button>
          <button
            onclick="(function() {
              this.event.preventDefault();
            })()"
            class="uk-button uk-button-primary drag-button">
            ${Drag()}
          </button>
          <button
            onclick="(function() {
              this.event.preventDefault();
              window.dpiSuperMenu.update({
                prop: 'removeColumn',
                id: ${this.id}
              });
            })()"
            class="uk-button uk-button-primary delete-button ${window.dpiSuperMenu.getProps('DropBar').count > 1 ? '' : 'dpi-sm-button-disabled'}">
            ${Close()}
          </button>
        </div>
      </div>
    `;
  }
}

import Column from './Column';

export default class DropBar {
  constructor(props) {
    this.props = props;
    this.bindEvents();
  }

  bindEvents() {
    this.columnCountChangedToken = window.dpiSuperMenu.events.on('column_count_changed', this.updateColumnCount.bind(this));
    this.columnAddedToken = window.dpiSuperMenu.events.on('column_added', this.injectColumn.bind(this));
    this.columnRemovedToken = window.dpiSuperMenu.events.on('column_removed', this.removeColumn.bind(this));
  }

  dismount() {
    window.dpiSuperMenu.events.off('column_count_changed', this.columnCountChangedToken);
    window.dpiSuperMenu.events.off('column_added', this.columnAddedToken);
    window.dpiSuperMenu.events.off('column_removed', this.columnRemovedToken);
  }

  injectColumn() {
    const length = window.dpiSuperMenu.getProps('Column').instances.length;
    const html = document.createRange().createContextualFragment(window.dpiSuperMenu.getProps('Column').instances[length - 1].render());
    window.dpiSuperMenu.root().querySelector('.dropbar-drag-container').appendChild(html);
  }

  removeColumn(id) {
    const parent = window.dpiSuperMenu.root().querySelector('.dropbar-drag-container');
    parent.removeChild(window.dpiSuperMenu.root().querySelector(`.drag-column[data-column-id="${id}"]`));
  }

  updateColumnCount() {
    const classes = Array.from(window.dpiSuperMenu.root().querySelector('.dropbar-drag-container').classList);
    classes.splice(classes.findIndex(className => className.startsWith('uk-column-1-')), 1);
    classes.push(`uk-column-1-${window.dpiSuperMenu.getProps('DropBar').count}`);
    window.dpiSuperMenu.root().querySelector('.dropbar-drag-container').className = classes.join(' ');
  }

  sortableInit() {
    try {
      const $ = jQuery;
      $('.dropbar-drag-container').sortable({
        connectWith: $('.uk-sortable-handle'),
        update: function(e, ui) {
          window.dpiSuperMenu.update({
            prop: 'columnsOrder',
            id: parseFloat(ui.item[0].dataset.columnId),
            order: Array.from(window.dpiSuperMenu.root().querySelectorAll('.drag-column[data-column-id]')).map(col => parseFloat(col.dataset.columnId))
          });
        }
      });
    } catch (err) {
      console.error('DPI Super Menu: Unable to start sortable.', err);
    }
  }

  setHeights() {
    const columns = Array.from(window.dpiSuperMenu.root().querySelectorAll('.drag-column'));
    columns[0].style.minHeight = '300px';
    if (columns.length > 1) {
      const minHeight = columns.map(col => col.clientHeight).reduce((pv, cv) => Math.max(pv, cv));
      columns.forEach(col => col.style.minHeight = `calc(${minHeight}px - 1em)`);
    }
  }

  postRender() {
    const observer = new MutationObserver(() => {
      this.sortableInit();
      this.setHeights();
      observer.disconnect();
    });
    observer.observe(window.dpiSuperMenu.root().querySelector('#menuItemType-root'), {childList: true, subtree: true});
  }

  getColumns() {
    if (window.dpiSuperMenu.getProps('Column').instances.length) {
      return window.dpiSuperMenu.getProps('Column').instances;
    } else {
      const newColumn = new Column({id: Math.floor((1 + Math.random()) * 0x10000), type: 'Blank'});
      window.dpiSuperMenu.getProps('Column').instances.push(newColumn);
      return window.dpiSuperMenu.getProps('Column').instances;
    }
  }

  render() {
    this.postRender();
    return `
      <div
        (function() {console.log('injected')})()
        class="uk-navbar-dropbar">
        <div class="dropbar-drag-container uk-column-1-${this.props.count}">
          ${this.getColumns().map(col => {
            return `
              <section class="uk-placeholder drag-column" data-column-id="${col.id}">
                <div class="uk-sortable-handle">
                  ${window.dpiSuperMenu.instance('ColumnControls', col.id)}
                  ${'render' in col ? col.render() : window.dpiSuperMenu.instance(col.type, col.id, col)}
                </div>
              </section>
            `;
          }).join('')}
        </div>
      </div>
    `;
  }
}

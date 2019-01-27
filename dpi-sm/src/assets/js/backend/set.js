import Column from './components/Column';

/**
* State setters, instead of mutating state directly we use setters -
* This way we can have basic type checking and other conditional logic -
* as well as emit any corresponding events.
*/

/**
* Set the menuItemName and emit menuItemName_changed event
* @param {obj} state - state to manipulate
* @param {obj} obj - must have a delta prop with the value to set
*
*/
export function set_menuItemName(state, obj) {
  if (typeof obj.delta === 'string') {
    state.components.ItemType.menuItemName = obj.delta;
    state.events.emit('menuItemName_changed');
  } else {
    console.error(`set_menuItemName expects a string, you passed a(n) ${typeof obj.delta}.`);
    return false;
  }
}

/**
* Set the menuItemType and emit menuItemType_changed event
* @param {obj} state - state to manipulate
* @param {obj} obj - must have a delta prop with the value to set
*
*/
export function set_menuItemType(state, obj) {
  if (typeof obj.delta === 'string') {
    state.components.ItemType.menuItemType = obj.delta;
    state.events.emit('menuItemType_changed');
  } else {
    console.error(`set_menuItemType expects a string, you passed a(n) ${typeof obj.delta}.`);
    return false;
  }
}

/**
* Set the url of the custom link and emit linkName_changed event
* @param {obj} state - state to manipulate
* @param {obj} obj - must have a delta prop with the value to set
*
*/
export function set_linkName(state, obj) {
  if (typeof obj.delta === 'string') {
    state.components.CustomLink.linkName = obj.delta;
    state.events.emit('linkName_changed');
  } else {
    console.error(`set_linkName expects a string, you passed a(n) ${typeof obj.delta}.`);
    return false;
  }
}

/**
* Set whether to open custom link in a new tab or not, emit a targetBlank_changed event
* @param {obj} state - state to manipulate
* @param {obj} obj - must have a delta prop with the value to set
*
*/
export function set_targetBlank(state, obj) {
  if (typeof obj.delta === 'string') {
    if (obj.delta === 'on') {
      state.components.CustomLink.targetBlank = true;
    } else {
      state.components.CustomLink.targetBlank = false;
    }
    state.events.emit('targetBlank_changed');
  } else {
    console.error(`set_targetBlank expects a string, you passed a(n) ${typeof obj.delta}.`);
    return false;
  }
}

/**
* Add a new column to the dropbar, emit column_added event
* @param {obj} state - state to manipulate
* @param {obj} obj - no props used but setters require one parameter
*
*/
export function set_newColumn(state, obj) {
  if (typeof obj === 'object') {
    const newColumn = new Column({id: Math.floor((1 + Math.random()) * 0x10000), type: 'Blank'});
    state.components.Column.instances.push(newColumn);
    set_columnCount(state, state.components.Column.instances.length);
    state.events.emit('column_added', newColumn);
  } else {
    console.error(`set_newColumn expects a object, you passed a(n) ${typeof obj}.`);
  }
}

/**
* Remove a column and all it's containing instances, emit column_removed event
* @param {obj} state - state to manipulate
* @param {obj} obj - must have an id prop with the id of column
*
*/
export function set_removeColumn(state, obj) {
  if (typeof obj === 'object' && typeof obj.id === 'number') {
    const type = state.components.Column.instances.filter(col => col.id === obj.id)[0].type;

    ['Column', 'ColumnControls', type].forEach((comp) => {
      const inst = state.components[comp].instances.filter(inst => inst.id === obj.id)[0];

      if (comp === 'ColumnControls') {
        console.log(inst);
      }

      if ('dismount' in inst) {
        inst.dismount();
      }

      state.components[comp].instances.splice(state.components[comp].instances.findIndex(inst => inst.id === obj.id), 1);
    });

    set_columnCount(state, state.components.Column.instances.length);
    state.events.emit('column_removed', obj.id);
  } else {
    console.error(`set_newColumn expects a object with a numerical id, you passed a ${typeof obj} and a(n) ${typeof obj.id} id.`);
  }
}

/**
* Change the count of columns, emit column_count_changed event
* @param {obj} state - state to manipulate
* @param {number} num - number of columns
*
*/
export function set_columnCount(state, num) {
  if (typeof num === 'number') {
    state.components.DropBar.count = num;
    state.events.emit('column_count_changed');
  } else {
    console.error(`set_ColumnCount expects a number, you passed a(n) ${typeof num}.`);
  }
}

/**
* Change the order of columns, emit column_order_changed event
* @param {obj} state - state to manipulate
* @param {obj} obj - must have an id prop with the id of column
*
*/
export function set_columnsOrder(state, obj) {
  if (typeof obj === 'object' && typeof obj.id === 'number') {
    const sorted = [];
    const columns = state.components.Column.instances;

    for (let i = 0; i < obj.order.length; i++) {
      sorted.push(columns[columns.findIndex(col => col.id === obj.order[i])]);
    }

    state.components.Column.instances = sorted;
    state.events.emit('column_order_changed');
  } else {
    console.error(`set_columns expects a object with a numerical id, you passed a(n) ${typeof obj} with a(n) ${typeof obj.id} id.`);
    return false;
  }
}

/**
* Set the instance type of a column, emit columnType_changed event
* @param {obj} state - state to manipulate
* @param {obj} obj - must have an id prop with the id of column
*
*/
export function set_columnType(state, obj) {
  if (typeof obj === 'object' && typeof obj.id === 'number') {
    console.log('set_columnType');
  } else {
    console.error(`set_columns expects a object with a numerical id, you passed a(n) ${typeof obj} with a(n) ${typeof obj.id} id.`);
    return false;
  }
}

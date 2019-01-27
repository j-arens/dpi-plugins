import dispatcher from '../Dispatcher';

export function createField(section, component, element, fieldType) {
  dispatcher.dispatch({
    type: 'ADD_FIELD',
    section,
    component,
    element,
    fieldType,
  });
}

export function deleteField(id) {
  dispatcher.dispatch({
    type: 'DELETE_FIELD',
    id
  });
}

export function updateField(id, prop, delta) {
  dispatcher.dispatch({
    type: 'UPDATE_FIELD',
    id,
    prop,
    delta
  });
}

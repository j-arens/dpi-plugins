import dispatcher from '../Dispatcher';

export function createElement(section, component, name) {
  dispatcher.dispatch({
    type: 'ADD_ELEMENT',
    section,
    component,
    name,
  });
}

export function deleteElement(id) {
  dispatcher.dispatch({
    type: 'DELETE_ELEMENT',
    id
  });
}

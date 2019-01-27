import dispatcher from '../Dispatcher';

export function createComponent(section, name) {
  dispatcher.dispatch({
    type: 'ADD_COMPONENT',
    section,
    name,
  });
}

export function deleteComponent(id) {
  dispatcher.dispatch({
    type: 'DELETE_COMPONENT',
    id
  });
}

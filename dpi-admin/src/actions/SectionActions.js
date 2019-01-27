import dispatcher from '../Dispatcher';

export function createSection(id, name) {
  dispatcher.dispatch({
    type: 'ADD_SECTION',
    id,
    name,
  });
}

export function deleteSection(id) {
  dispatcher.dispatch({
    type: 'DELETE_SECTION',
    id
  })
}

export function changeItemName(name) {
  return {
    type: 'CHANGE_ITEMNAME',
    name
  }
}

export function changeItemType(itemType) {
  return {
    type: 'CHANGE_ITEMTYPE',
    itemType
  }
}

export function changeLinkURL(url) {
  return {
    type: 'CHANGE_LINKURL',
    url
  }
}

export function changeTargetBlank(blank) {
  return {
    type: 'CHANGE_TARGETBLANK',
    blank
  }
}

export function addColumn(columnType) {
  return {
    type: 'ADD_COLUMN',
    columnType
  }
}

export function deleteColumn(id) {
  return {
    type: 'DELETE_COLUMN',
    id
  }
}

export function changeColumnOrder(order) {
  return {
    type: 'CHANGE_COLUMN_ORDER',
    order
  }
}

export function changeColumnInstance(id, instance) {
  return {
    type: 'CHANGE_COLUMN_INSTANCE',
    id,
    instance
  }
}

export function addImage(id, imageURL, imageID) {
  return {
    type: 'ADD_IMAGE',
    id,
    imageURL,
    imageID
  }
}

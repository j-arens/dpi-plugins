/**
* State getters, instead of querying the model directly we can process query's and return only what we want returned
*/

export function get_ItemType(state) {
  return state.components.ItemType;
}

export function get_CustomLink(state) {
  return state.components.CustomLink;
}

export function get_CustomSection(state) {
  return state.components.CustomSection;
}

export function get_ModelNav(state) {
  return state.components.ModelNav;
}

export function get_DropBar(state) {
  return state.components.DropBar;
}

export function get_Column(state) {
  return state.components.Column;
}

export function get_SubMenu(state) {
  return state.components.SubMenu;
}

export default class SubMenu {
  constructor(props) {
    this.props = props;
  }

  render() {
    return `
      <ul class="uk-nav uk-navbar-dropdown-nav">
        <li class="uk-active"><a href="#">Active</a></li>
        <li><a href="#">Item</a></li>
        <li class="uk-nav-header">Header</li>
        <li><a href="#">Item</a></li>
        <li><a href="#">Item</a></li>
        <li><a href="#">Item</a></li>
        <li><a href="#">Item</a></li>
        <li><a href="#">Item</a></li>
      </ul>
    `;
  }
}

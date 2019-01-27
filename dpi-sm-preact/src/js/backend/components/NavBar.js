import { h } from 'preact';

// components
import DropBar from './DropBar';

const getNavItems = () => {
  return ['item 1', 'item 2', 'item 3'];
}

const NavBar = () => (
  <div class="uk-position-relative">
    <nav class="uk-navbar-container">
      <ul class="uk-navbar-nav">
        {getNavItems().map(item =>
          <li>
            <a href="#">{item}</a>
          </li>
        )}
      </ul>
    </nav>
    <DropBar />
  </div>
);

export default NavBar;

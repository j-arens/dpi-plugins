import React from 'react';

// components
import PageLink from './PageLink';

// styles
import style from '../styles/_side-nav.css';

export default class SideNav extends React.Component {
  handleClick(page) {
    this.props.changePage(page);
  }

  render() {
    return (
      <aside id={style.sideNav}>
        <nav>
          <a target="_blank" className={style.logoBox} href="http://diocesan.com">
            <h2><strong>DPI</strong> Admin</h2>
          </a>
          <ul>
            {this.props.pages.map((page) => <PageLink
                key={page.id}
                id={page.id}
                name={page.name}
                currentPage={this.props.currentPage}
                handleClick={this.handleClick.bind(this, page)} />)}
          </ul>
        </nav>
      </aside>
    );
  }
}

SideNav.propTypes = {
  changePage: React.PropTypes.func.isRequired,
  pages: React.PropTypes.array.isRequired,
  currentPage: React.PropTypes.number.isRequired,
}

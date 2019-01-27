import React from 'react';

// components
import SideNav from '../components/SideNav';
import InnerContainer from '../components/InnerContainer';
import PopDown from '../components/PopDown';

// styles
import style from '../styles/_layout.css';

export default class Layout extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      currentPage: props.pages[0].id ? props.pages[0].id : 1,
    }
  }

  changePage(page) {
    if (this.state.currentPage === page.id) {
      return;
    } else {
      this.setState({
        currentPage: page.id,
      });
    }
  }

  render() {
    return (
      <div className={style.mainContainer}>
        <PopDown />
        <SideNav
          changePage={this.changePage.bind(this)}
          pages={this.props.pages}
          currentPage={this.state.currentPage}
        />
        <InnerContainer currentPage={this.state.currentPage}/>
      </div>
    );
  }
}

Layout.propTypes = {
  pages: React.PropTypes.array.isRequired,
}

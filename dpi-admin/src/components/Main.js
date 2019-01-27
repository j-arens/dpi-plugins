import React from 'react';

// stores
import PagesStore from '../stores/PagesStore';

// actions
import * as AppActions from '../actions/AppActions';

// components
import Layout from '../pages/Layout';

// styles
import loaderStyles from '../styles/_loaders.css';
import controlStyles from '../styles/_controls.css';

export default class Main extends React.Component {
  constructor() {
    super();

    this.updatePages = this.updatePages.bind(this);
    this.fetchError = this.fetchError.bind(this);
    this.showLoader = this.showLoader.bind(this);

    this.state = {
      pages: PagesStore.getVisible(),
      loading: true,
      error: false,
      errMsg: '',
    };
  }

  componentWillMount() {
    AppActions.loadState();
    // PagesStore.on('savingState', this.showLoader);
    PagesStore.on('fetchError', this.fetchError);
    PagesStore.on('pageAdded', this.updatePages);
    PagesStore.on('pageRemoved', this.updatePages);
  }

  componentWillUnmount() {
    AppActions.saveState();
    // PagesStore.removeListener('savingState', this.showLoader);
    PagesStore.removeListener('fetchError', this.fetchError);
    PagesStore.removeListener('pageAdded', this.updatePages);
    PagesStore.removeListener('pageRemoved', this.updatePages);
  }

  updatePages() {
    this.setState({
      pages: PagesStore.getVisible(),
      loading: false,
    });
  }

  fetchError() {
    this.setState({
      pagesStore: [],
      error: true,
      errMsg: PagesStore.errMsg(),
    });
  }

  showLoader() {
    this.setState({
      loading: true,
    });
  }

  render() {
    return (
      <main>
        {this.state.error === true ? <div className={controlStyles.fatalError}><p>Uh oh, there was an error!</p><pre>err - {this.state.errMsg}</pre></div> : this.state.loading === true ? <div className={loaderStyles.dpiAdminLoader}><div className={loaderStyles.spinner}></div></div> : <Layout pages={this.state.pages} />}
      </main>
    );
  }
}

import React from 'react';
import ReactDOM from 'react-dom';

// components
import Main from './components/Main';

// styles
import './styles/index.css';

const root = document.getElementById('dpi-admin-root');

if (root) {
  ReactDOM.render( <Main />, root);
}

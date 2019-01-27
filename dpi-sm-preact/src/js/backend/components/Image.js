import { h } from 'preact';
// import { connect } from 'preact-redux';
// import * as actions from '../actions';

let Image = ({ instance }) => (
  <figure class="image" style={`background-image: url(${instance.imageURL})`}></figure>
);

// Image = connect(null, actions)(Image);

export default Image;

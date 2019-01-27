import { h } from 'preact';
import { connect } from 'preact-redux';
import * as actions from '../actions';

let SectionControls = ({ addColumn }) => (
  <section class="uk-margin-bottom">
    <div class="uk-button-group">
      <button
        class="uk-button uk-button-primary"
        onClick={(e) => {e.preventDefault(); addColumn('Blank')}}
      >
      + Add A Column
      </button>
      <button
        class="uk-button uk-button-default"
        onClick={(e) => {e.preventDefault()}}
      >
      Option
      </button>
    </div>
    <button
      class="uk-button uk-button-danger uk-align-right"
      onClick={(e) => {e.preventDefault()}}
    >
    Reset
    </button>
  </section>
);

SectionControls = connect(null, actions)(SectionControls);

export default SectionControls;

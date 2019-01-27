import { h } from 'preact';
import { connect } from 'preact-redux';
import model from '../model';
import * as actions from '../actions';

// icons
import Dropdown from '../icons/Dropdown';
import Drag from '../icons/Drag';
import Close from '../icons/Close';

const mapStateToProps = (model) => {
  return model.customSection;
}

let ColumnControls = ({ id, columns, deleteColumn, changeColumnInstance }) => (
  <div class="column-controls">
    <div class="uk-button-group">
      <button
        class="uk-button uk-button-primary dropdown-button"
        onClick={(e) => {e.preventDefault(); changeColumnInstance(id, 'ColumnTypeSelector')}}
      >
      {Dropdown()}
      </button>
      <button
        class="uk-button uk-button-primary drag-button"
        onClick={(e) => {e.preventDefault()}}
      >
      {Drag()}
      </button>
      <button
        class={'uk-button uk-button-primary delete-button ' + (columns.length > 1 ? '' : 'dpi-sm-button-disabled')}
        onClick={(e) => {e.preventDefault(); deleteColumn(id)}}
      >
      {Close()}
      </button>
    </div>
  </div>
);

ColumnControls = connect(mapStateToProps.bind(model), actions)(ColumnControls);

export default ColumnControls;

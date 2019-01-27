import { h } from 'preact';
import { connect } from 'preact-redux';
import model from '../model';

// components
import ColumnWrapper from './Column';

const mapStateToProps = (model) => {
  return model.customSection;
}

let DropBar = ({ columns }) => (
  <div class="uk-navbar-dropbar">
    <div class={'dropbar-drag-container uk-column-1-' + columns.length}>
      {columns.map(col =>
        <ColumnWrapper id={col.id} type={col.type} instance={col.instance} />
      )}
    </div>
  </div>
);

DropBar = connect(mapStateToProps.bind(model))(DropBar);

export default DropBar;

import { h, render, Component } from 'preact';
import { connect } from 'preact-redux';
import * as actions from '../actions';

// components
import ColumnControls from './ColumnControls';
import ColumnTypeSelector from './ColumnTypeSelector';
import ImageWrapper from './ImageWrapper';
import Blank from './Blank';

class Column extends Component {
  constructor(props) {
    super(props);
    this.changeColumnOrder = props.changeColumnOrder;
  }

  sortableInit(changeOrder) {
    try {
      const $ = jQuery;
      $('.dropbar-drag-container').sortable({
        connectWith: $('.uk-sortable-handle'),
        update: function() {
          const order = Array.from(window.dpiSuperMenu.root().querySelectorAll('.drag-column')).map(col => col.getAttribute('data-column-id'));
          changeOrder(order);
        }
      });
    } catch(err) {
      console.error('DPI Super Menu: Unable to start sortable.');
    }
  }

  setHeights() {
    const columns = Array.from(window.dpiSuperMenu.root().querySelectorAll('.drag-column'));
    columns[0].style.minHeight = '300px';

    if (columns.length > 1) {
      const minHeight = columns.map(col => col.clientHeight).reduce((pv, cv) => Math.max(pv, cv));
      columns.forEach(col => col.style.minHeight = `calc(${minHeight}px - 1em)`);
    }
  }

  componentDidMount() {
    this.setHeights();
    this.sortableInit(this.changeColumnOrder);
  }

  renderInstance(instance, id, type) {
    switch (instance) {
      case 'ColumnTypeSelector':
        return <ColumnTypeSelector id={id} type={type} />
      case 'Image':
        return <ImageWrapper id={id} />
      default:
        return <Blank />
    }
  }

  render({ id, type, instance }) {
    return (
      <section class="uk-placeholder drag-column" data-column-id={id}>
        <div class="uk-sortable-handle">
          <ColumnControls id={id} />
          {this.renderInstance(instance, id, type)}
          {id}
        </div>
      </section>
    );
  }
}

const ColumnWrapper = connect(null, actions)(Column);

export default ColumnWrapper;

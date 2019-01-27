import Dropdown from '../icons/Dropdown';

export default class Blank {
  render() {
    return `
      <div class="Blank">
        <div class="Blank-helper-message">
          <p class="uk-text-meta uk-text-large">Blank</p>
          <p class="uk-text-meta">Click the ${Dropdown()} button above to change the column type.</p>
        </div>
      </div>
    `;
  }
}

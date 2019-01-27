import React from 'react';

export default class BuilderRadioButtonsField extends React.Component {
  render() {
    return (
      <div className="modal-sm field">
        <div className="modaltitlebar">
          <p className="title">Radio Buttons</p>
          <div className="controls"></div>
        </div>
        <div className="field-input">
          <label>
            Name
            <input type="text" />
          </label>
          <label>
            Description
            <input type="text" />
          </label>
        </div>
        <em><small>get_option( 'dpi_opt_header_quick_links_link_1_text_0' )</small></em>
      </div>
    );
  }
}

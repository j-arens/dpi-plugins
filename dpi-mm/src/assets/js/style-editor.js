const styleEditor = (function($) {

  let $body,
    $styleEl,
    $saveBtn,
    $resetBtn;

  function init() {
    cacheDom();
    appendBtns();
    bindEvents();
  }

  function cacheDom(round2) {
    if (!round2) {
      $body = $('body');
      $styleEl = $body.find('#dpi-mm-editable-styles');
    } else {
      $saveBtn = $styleEl.find('#dpi-mm-save-styles');
      $resetBtn = $styleEl.find('#dpi-mm-reset-styles');
    }
  }

  function appendBtns() {
    const saveBtn = '<button id="dpi-mm-save-styles">Save Styles</button>';
    const resetBtn = '<button id="dpi-mm-reset-styles">Reset Styles</button>';
    const container = '<div contenteditable="false">' + saveBtn + resetBtn + '</div>';

    $styleEl.append(container);
    cacheDom(true);
  }

  function bindEvents() {
    $styleEl.on('dragstart', dragStart);
    $body.on('drop', drop);
    $styleEl.on('keydown', preventBreaks);
    $saveBtn.on('click', saveStyles);
    $resetBtn.on('click', resetStyles);
  }

  function dragStart(e) {
    const coords = $(e.target).offset();
    e.originalEvent.dataTransfer.setData('text/plain', (coords.left - e.clientX) + ',' + (coords.top - e.clientY));
  }

  function drop(e) {
    const offset = e.originalEvent.dataTransfer.getData('text/plain').split(',');

    $styleEl.css({
      top: e.clientY + parseInt(offset[1], 10),
      left: e.clientX + parseInt(offset[0], 10)
    });

    e.preventDefault();
    return false;
  }

  function preventBreaks(e) {
    if (e.which === 13) {
      e.preventDefault();
    }
  }

  function saveStyles() {
    console.log('save styles');
  }

  function resetStyles() {
    console.log('reset styles');
  }

  return {
    init: init
  }

})(jQuery);

export default styleEditor;

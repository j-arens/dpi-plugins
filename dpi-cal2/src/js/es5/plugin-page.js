const dpiCalPluginPage = (function($) {

  function colorPicker() {
    $('.dpi-cal-color').wpColorPicker({
      palettes: true
    });
  }

  function init() {
    colorPicker();
  }

  return {
    init() {
      $(document).ready(init);
    }
  }

})(jQuery);

dpiCalPluginPage.init();

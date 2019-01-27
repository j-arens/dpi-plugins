const dpiCustomizer = (function($, local) {

  const customizer = window.wp.customize;

  function renderBackgroundColor(setting) {
    customizer(setting.id, (val) => val.bind(to => {
      if (!to) {
        $(setting.selector).css({
          backgroundColor: 'transparent'
        });
      } else {
        $(setting.selector).css({
          backgroundColor: to
        });
      }
    }));
  }

  function renderColor(setting) {
    customizer(setting.id, (val) => val.bind(to => {
      if (!to) {
        $(setting.selector).css({
          color: '#000'
        });
      } else {
        $(setting.selector).css({
          color: to
        });
      }
    }));
  }

  function renderBackgroundImage(setting) {
    customizer(setting.id, (val) => val.bind(to => {
      if (!to) {
        $(setting.selector).hide();
      } else {
        $(setting.selector).show();
        $(setting.selector).css({
          backgroundImage: `url(${to})`
        });
      }
    }));
  }

  function renderImage(setting) {
    customizer(setting.id, (val) => val.bind(to => {
      if (!to) {
        $(setting.selector).hide();
      } else {
        $(setting.selector).show();
        $(setting.selector).attr('src', to);
      }
    }));
  }

  function renderText(setting) {
    customizer(setting.id, (val) => val.bind(to => $(setting.selector).text(to)));
  }

  function bindRenderMethod() {
    JSON.parse(local).forEach(setting => {
      switch(setting.type) {
        case 'color':
          renderColor(setting);
          break;
        case 'background_color':
          renderBackgroundColor(setting);
          break;
        case 'image':
          renderImage(setting);
          break;
        case 'background_image':
          renderBackgroundImage(setting);
          break;
        default:
          renderText(setting);
          break;
      }
    });
  }

  function init() {
    if (!local) {
      console.error('DPI Customizer: Unable to get localized data!');
      return false;
    } else {
      bindRenderMethod()
    }
  }

  return {
    init() {
      $(document).ready(init);
    }
  }

})(jQuery, dpi_cust_local);

dpiCustomizer.init();

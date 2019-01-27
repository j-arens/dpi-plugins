import styleEditor from './style-editor';

(function($) {
  $.extend({
    dpiMenu: (function() {

      // dom element vars
      let $nav,
        $tpl,
        $mainMenu,
        $mobileToggle;

      // keep track of state
      const state = {
        active: false,
        currentLink: null,
      };

      // start up sequence
      function init() {
        cacheDom();
        bindEvents();
      }

      // cache dom elements
      function cacheDom() {
        $nav = $('#dpi-mega-menu');
        $mobileToggle = $nav.find('.mobile-toggle');
        $mainMenu = $nav.find('#menu-primary-menu');
        $tpl = $mainMenu.find('.tpl');
      }

      // bind event listeners
      function bindEvents() {
        $tpl.each(function() {
          $(this).on('click tap', clickHandler);
        });
        $mobileToggle.on('click', toggleMobileMenu);
      }

      // route events
      function clickHandler(e) {
        if ($(e.target).hasClass('tpl-title')) {
          render($(e.target).closest('li').index());
        }
      }

      // menu manipulation
      function render(i) {

        // if no menus are active, open sub menu
        if (!state.active) {

          $($tpl[i]).addClass('tpl-active');

          state.currentLink = i;
          state.active = !state.active;

        // close sub menu and remove active if click was on already active tpl
        } else if (state.currentLink === i) {

          $tpl.each(function() {
            $(this).removeClass('tpl-active');
          });

          state.currentLink = null;
          state.active = !state.active;

        // otherwise swap active menu to clicked on tpl
        } else {

          $tpl.each(function() {
            $(this).removeClass('tpl-active');
          });

          $($tpl[i]).addClass('tpl-active');

          state.currentLink = i;
        }
      }

      function toggleMobileMenu() {
        $nav.toggleClass('active');
      }

      // api
      return {
        init: init
      };

    })()
  });

  // kick things off
  $(document).ready(function() {
    $.dpiMenu.init();
    styleEditor.init();
  });

})(jQuery);

import renderErr from './components/error';
import Modal from './components/modal';
import Calendar from './components/calendar';

const dpiCal = (function($, local) {

  let currentEvent;

  function sizeCalendar() {
    const windowWidth = $(window).width();
    const breakpoint_md = 1200;
    const breakpoint_sm = 768;
    let view;

    if (windowWidth <= breakpoint_md && windowWidth > breakpoint_sm) {
      view = 'basicWeek';
    } else if (windowWidth <= breakpoint_sm) {
      view = 'basicDay';
    } else {
      view = local.format;
    }

    return view;
  }

  function closeModal(e) {
    $(e.target).closest('.dpi-cal-event-modal').remove();
  }

  function closeAllModals() {
    $('.dpi-cal-event-modal').each(function() {
      $(this).remove();
    });
  }

  function handleClick(ce, je, v) {
    switch (v.type || v.name) {
      case 'month':
      case 'basicWeek':
        if (!je.target.classList.contains('dpi-cal-event-link')) {
          je.preventDefault();
          if (je.target.classList.contains('dpi-cal-close')) {
            currentEvent = null;
            closeModal(je);
          } else if (currentEvent !== ce.id) {
            currentEvent = ce.id;
            closeAllModals();
            const eventModal = new Modal(ce, je);
            eventModal.render();
          }
        }
        break;
      default:
        return false;
    }
  }

  function init() {
    window.dpi_cal_localized = undefined;
    if (!local) {
      renderErr();
    } else {
      const cal = new Calendar(local);
      cal.render();
    }
  }

  return {
    sizeCalendar() {
      return sizeCalendar();
    },
    closeModal(e) {
      return closeModal(e);
    },
    closeAllModals() {
      return closeAllModals();
    },
    handleClick(ce, je, v) {
      handleClick(ce, je, v)
    },
    init() {
      $(document).ready(init);
    }
  }

})(window.jQuery, window.dpi_cal_localized);

window.dpiCal = dpiCal;
dpiCal.init();

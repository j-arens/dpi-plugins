(function($, opts) {

  let $body,
      $selector;

  function init() {
    if (!opts || typeof opts !== 'object') {
      destroyData();
      return;
    } else {
      destroyData();
      cacheDom();
      bindEvents();
      buildCal();
    }
  }

  function cacheDom() {
    $body = $('body');
    $selector = $body.find(opts.selector);
  }

  function bindEvents() {
    $body.delegate('.dpi-cal-close-modal', 'click', closeModal);
  }

  function handleClick(ce, je, v) {
    if (v.type !== 'month') {
      return;
    } else {
      je.preventDefault();
      closeAllModals();
      $body.append(buildModal(ce, je));
    }
  }

  function closeAllModals() {
    $body.find('.dpi-cal-event-info').each(function() {
      $(this).remove();
    });
  }

  function closeModal(e) {
    $(e.target).closest('.dpi-cal-event-info').remove();
  }

  function buildModal(ce, je) {
    let $_target = null;

    if ($(je.target).context.tagName === 'A') {
      $_target = $(je.target).find('.fc-content');
    } else {
      $_target = $(je.target).closest('.fc-content');
    };

    const coords = $_target.offset();
    const targetHeight = $_target.height();

    const x = Math.ceil(coords.top) + targetHeight + 11; // 11 to adjust for tooltip arrow
    const y = Math.ceil(coords.left);

    const style = 'style="top: ' + x + 'px; left: ' + y + 'px;"';
    const className = 'class="dpi-cal-event-info"';
    const id = 'data-id="' + ce._id + '"';

    const modal = `
      <div ${id} ${className} ${style}>
        <div class="dpi-cal-tooltip-arrow"></div>
        <button class="dpi-cal-close-modal">
          <svg class="dpi-cal-close-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M13 7h-2v4H7v2h4v4h2v-4h4v-2h-4V7zm-1-5C6.49 2 2 6.49 2 12s4.49 10 10 10 10-4.49 10-10S17.51 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
        </button>
        <p class="dpi-cal-event-title">${ce.title}</p>
        <a href="${ce.url}" target="_blank">See more details</a>
      </div>
    `;

    return modal;
  }

  function buildCal() {
    $selector.fullCalendar({
      defaultView: opts.view,
      eventColor: opts.event_color,
      editable: false,
      handleWindowResize: true,
      googleCalendarApiKey: opts.api,
      events: {
        googleCalendarId: opts.id,
      },
      viewRender: function() {closeAllModals()},
      eventClick: function(ce, je, v) {handleClick(ce, je, v)},
    });
  }

  function destroyData() {
    dpi_cal_opts = undefined;
  }

  // kick things off
  $(document).ready(init);

})(jQuery, dpi_cal_opts);

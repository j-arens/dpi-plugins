export default class Calendar {
  constructor(settings) {
    this.local = settings;
    this.jq = window.jQuery;
  }

  customStyles() {
    return `
      <style>
        .fc-state-highlight > div > div.fc-day-number {
          background-color: ${this.local.secondary_color};
        }

        .fc-week .fc-day.fc-state-highlight:hover .fc-day-number {
          background-color: ${this.local.secondary_color};
        }

        .fc-state-disabled {
          color: ${this.local.secondary_color} !important;
          background-color: ${this.shadeColor(this.local.secondary_color, 0.8)} !important;
        }

        .fc-state-default {
          border-color: ${this.local.secondary_color};
          color: ${this.local.secondary_color};
        }

        .fc-state-hover {
          color: ${this.local.secondary_color};
          background-color: ${this.shadeColor(this.local.secondary_color, 0.8)} !important;
        }

        .fc-state-active {
          background-color: ${this.local.secondary_color} !important;
        }

        .fc-state-down {
          background-color: ${this.local.secondary_color} !important;
        }

        .fc-event:hover {
          background-color: ${this.shadeColor(this.local.primary_color, 0.4)} !important;
        }

        .dpi-cal-close-icon {
          fill: ${this.local.secondary_color} !important;
        }
      </style>
    `;
  }

  shadeColor(color, percent) {
    var f=parseInt(color.slice(1),16),t=percent<0?0:255,p=percent<0?percent*-1:percent,R=f>>16,G=f>>8&0x00FF,B=f&0x0000FF;
    return "#"+(0x1000000+(Math.round((t-R)*p)+R)*0x10000+(Math.round((t-G)*p)+G)*0x100+(Math.round((t-B)*p)+B)).toString(16).slice(1);
  }

  render() {
    // append custom styles to head
    this.jq('head').append(this.customStyles());

    // add dpi-calendar class to body just because I can
    this.jq('body').addClass('dpi-calendar');

    // let fullcalendar do the rest of the work
    this.jq('#dpi-cal-calendar').fullCalendar({
      defaultView: window.dpiCal.sizeCalendar(),
      eventBackgroundColor: this.local.primary_color,
      eventTextColor: this.local.text_color,
      editable: false,
      handleWindowResize: true,
      events: {
        googleCalendarApiKey: atob(this.local.key),
        googleCalendarId: atob(this.local.id),
        className: 'gcal-event',
        currentTimezone: this.local.timezone
      },
      viewRender() {
        window.dpiCal.closeAllModals()
      },
      eventClick(ce, je, v) {
        window.dpiCal.handleClick(ce, je, v);
      },
      windowResize(currentView) {
        const newView = window.dpiCal.sizeCalendar();

        if (newView !== currentView) {
          jQuery(this).fullCalendar('changeView', newView);
        }
      }
    });

    // listen for clicks on event modals
    this.jq('body').delegate('.dpi-cal-close-modal', 'click', this.closeModal);
  }
}

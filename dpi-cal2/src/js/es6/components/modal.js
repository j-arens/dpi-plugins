export default class Modal {
  constructor(ce, je) {
    this.jq = window.jQuery;
    this.ce = ce;
    this.$target = this.jq(je.target).closest('.fc-event');
  }

  render() {
    this.$target.append(`
      <span class="dpi-cal-event-modal">
        <button class="dpi-cal-close dpi-cal-close-modal">
          <svg class="dpi-cal-close dpi-cal-close-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path class="dpi-cal-close" d="M13 7h-2v4H7v2h4v4h2v-4h4v-2h-4V7zm-1-5C6.49 2 2 6.49 2 12s4.49 10 10 10 10-4.49 10-10S17.51 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
        </button>
        <p class="dpi-cal-event-title">${this.ce.title}</p>
        <a class="dpi-cal-event-link" href="${this.ce.url}" target="_blank">See More Details</a>
      </span>
    `);
  }
}

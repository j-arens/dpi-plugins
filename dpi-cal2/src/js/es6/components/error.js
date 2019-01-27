export function renderErr() {
  const jq = window.jQuery;
  const errorHTML = `
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
    <p>Sorry, we\'re unable to retreive your calendar right now. <pre>Error: Localized data undefined.</pre></p>
  `;

  const errStyles = `
    <style>
    .dpi-cal-error {
      display: flex;
      position: relative;
      background: #d94f4f;
      padding: 16px 16px 16px 60px;
      color: #fff;
      font-size: 16px;
    }

    .dpi-cal-error svg {
      fill: #fff;
      padding: 0 8px;
      width: 44px;
      height: 100%;
      margin-right: 8px;
      position: absolute;
      top: 0;
      left: 0;
      background: #b52727;
    }

    .dpi-cal-error p {
      color: #fff;
      font-size: 15px;
      margin: 0;
    }

    .dpi-cal-error pre {
      margin: 1px 0 0 16px;
    }
    </style>
  `;

  jq('head').append(errStyles);
  jq('#dpi-cal-calendar').addClass('dpi-cal-error').html(errorHTML);
  console.error('DPI Cal: Unable to load localized data.');
}

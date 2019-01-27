const dpiCC = (function($, local) {

  let root,
      form,
      input;

  function alertError() {
    input.classList.add('submit-error');
    form.innerHTML = `
      <div class="dpi-cc-form-error">
        <p>Uh oh, there was an error! Please try again later.</p>
      </div>
    `;
  }

  function alertSuccess() {
    form.innerHTML = `
      <div class="dpi-cc-form-success">
        <p>Your email has been submitted, thanks!</p>
      </div>
    `;
  }

  function alertInvalid() {
    form.reset();
    input.classList.add('input-invalid');
    input.setAttribute('placeholder', 'Email is invalid');

    const removeClass = setInterval((input) => {
      input.classList.remove('input-invalid');
      clearInterval(removeClass);
    }, 500, input);
  }

  function postEmail(e) {
    e.preventDefault();
    const value = input.value;

    if (!isValid(value)) {
      alertInvalid();
    } else {
      const data = {
        'action': 'dpi_cc_submit',
        'dpi_cc_email': value,
        'nonce': local.nonce
      }

      $.post(local.ajaxurl, data).done((res) => {
        if (res.success) {
          alertSuccess();
        } else {
          alertError();
        }
      });
    }
  }

  function isValid(email) {
    const regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return regex.test(email);
  }

  function init() {
    window.dpi_cc_local = undefined;
    root = document.getElementById('dpi-cc-form-root');

    try {
      form = root.form;
      input = form.querySelector('input[type="email"]');
      form.addEventListener('submit', postEmail);

      if (!local) {
        console.error('DPI CC: Unable to get localized data!');
        alertError();
      }
    } catch(err) {
      console.error('DPI CC: Unable to bind events!', err);
    }
  }

  return {
    init() {
      if (document.readyState != 'loading'){
        init();
      } else {
        document.addEventListener('DOMContentLoaded', init);
      }
    }
  }

})(jQuery, window.dpi_cc_local);

dpiCC.init();

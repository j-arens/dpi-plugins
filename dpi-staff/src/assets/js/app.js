import 'babel-polyfill';

require('../css/main.css');

const dpiStaff = (function($) {

  const state = {
    imageUrl: '',
    imageID: '',
    name: '',
    position: '',
    email: '',
    phone: ''
  }

  let $addStaffBtn,
      $wpcontent;

  function init() {
    cacheDom();
    bindEvents();
  }

  function cacheDom() {
    $addStaffBtn = $('#dpi-staff');
    $wpcontent = $('#wpcontent');
  }

  function bindEvents() {
    try {
      $addStaffBtn.on('click', openModal);
    } catch(err) {
      console.error(`DPI Staff: ${err}`);
      return;
    }
    $wpcontent.delegate('.dpi-staff-modal', 'click', modalHandleClick);
  }

  function modalHandleClick(e) {
    const $targetClass = $(e.target).attr('class');
    if ($targetClass) {
      if ($targetClass.includes('dpi-staff-close')) {
        closeModal();
      } else if ($targetClass.includes('dpi-staff-img')) {
        if (!state.imageUrl) {
          loadMedia();
        } else {
          removeImage();
        }
      } else if ($targetClass.includes('dpi-staff-submit')) {
        getValues();
        appendShortcode();
        clearState();
        closeModal();
      }
    }
  }

  function openModal() {
    $wpcontent.append(Modal());
  }

  function closeModal() {
    $('.dpi-staff-modal').remove();
    $('.dpi-staff-overlay').remove();
    state.imageUrl = '';
    state.imageID = '';
  }

  function loadMedia() {
    if (!state.hasOwnProperty('mediaWindow')) {
      state.mediaWindow = wp.media({
        title: 'Insert Staff Photo',
        library: {type: 'image'},
        multiple: false,
        button: {text: 'insert'}
      });

      state.mediaWindow.on('select', () => {
        const data = state.mediaWindow.state().get('selection').first().toJSON();
        state.imageUrl = data.sizes.medium.url;
        state.imageID = data.id;
        setImage();
      });
    }

    state.mediaWindow.open();
    return false;
  }

  function setImage() {
    const $staffPhoto = $('.dpi-staff-img');

    $staffPhoto.css({
      backgroundImage: `url(${state.imageUrl})`
    });

    $staffPhoto.removeClass('empty');
    $staffPhoto.addClass('set');
  }

  function removeImage() {
    const $staffPhoto = $('.dpi-staff-img');

    $staffPhoto.css({
      backgroundImage: `url()`
    });

    $staffPhoto.removeClass('set');
    $staffPhoto.addClass('empty');

    state.imageUrl = '';
    state.imageID = '';
  }

  function getValues() {
    const $inputs = $('.dpi-staff-modal input');
    $inputs.each(function() {
      state[this.getAttribute('name')] = this.value;
    });
  }

  function clearState() {
    for (const value in state) delete state[value];
  }

  function appendShortcode() {
    wp.media.editor.insert(`[dpi_staff img_id="${state.imageID || ''}" position="${state.position || ''}" name="${state.name || ''}" phone="${state.phone || ''}" email="${state.email || ''}"]`);
  }

  function Modal() {
    return `
      <div class="dpi-staff-overlay">
        <div class="dpi-staff-modal">
          <button class="dpi-staff-close">X</button>
          <section class="dpi-staff-photo">
            <div class="dpi-staff-img empty"></div>
          </section>
          <section class="dpi-staff-info">
            <label>
              Name
              <input type="text" name="name" />
            </label>
            <label>
              Position
              <input type="text" name="position" />
            </label>
            <label>
              Email
              <input type="text" name="email"/>
            </label>
            <label>
              Phone
              <input type="text" name="phone" />
            </label>
          </section>
          <button class="dpi-staff-submit">Add Staff</button>
        </div>
      </div>
    `;
  }

  return {
    init
  }

})(jQuery);

dpiStaff.init();

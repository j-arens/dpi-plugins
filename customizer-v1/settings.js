(function($) {

  var customizer = {
    init: function() {
      this.cacheDom();
      this.$optPage.css({height: ($(window).height() - 32)});
      this.bindEvents();
      this._vendor.colorPicker();
      this._vendor.imagePicker();
    },
    cacheDom: function(newpage) {
      if (newpage) {
        this.$tabNav = this.$optPage.find('.active-section .tab-nav');
        this.$tabNavLi = this.$tabNav.find('li');
        this.$components = this.$optPage.find('.active-section .tab-panel li');
      } else {
        this.$optPage = $('#dpi-opt-page');
        this.$pageNav = this.$optPage.find('.site-section-nav');
        this.$pageNavLi = this.$pageNav.find('li');
        this.$siteSection = this.$optPage.find('.site-section');
        this.$tabNav = this.$optPage.find('.active-section .tab-nav');
        this.$tabNavLi = this.$tabNav.find('li');
        this.$components = this.$optPage.find('.active-section .tab-panel li');
      }
    },
    render: function() {
      this.$tabNav.undelegate('li', 'click');
      this.cacheDom(true);
      this.bindEvents(true);
    },
    bindEvents: function(newpage) {
      if (newpage) {
        this.$tabNav.delegate('li:not(.active-part)', 'click', this.changeComponent.bind(this));
      } else {
        this.$pageNav.delegate('li:not(.active-tab)', 'click', this.changePage.bind(this));
        this.$tabNav.delegate('li:not(.active-part)', 'click', this.changeComponent.bind(this));
      }
    },
    changePage: function(e) {
      var $clicked = $(e.target).closest('li');
      var i = this.$pageNav.find('li').index($clicked);
      var $elArr = [[this.$pageNavLi, 'active-tab', i], [this.$siteSection, 'active-section', i]];

      $elArr.forEach(this.changeClass);
      this.render();
    },
    changeComponent: function(e) {
      var $clicked = $(e.target).closest('li');
      var i = this.$tabNav.find('li').index($clicked);
      var $elArr = [[this.$tabNavLi, 'active-part', i], [this.$components, 'active-component', i]];

      $elArr.forEach(this.changeClass);
    },
    changeClass: function(el, i, arr) {
      $(arr[i][0]).each(function() {
        $(this).removeClass(arr[i][1]);
      });

      $(arr[i][0][arr[i][2]]).addClass(arr[i][1]);
    },
    _vendor: {
      colorPicker: function() {
        $('.colorpicker').each( function() {
            $(this).farbtastic( $(this).closest('.color-picker').find('.color') );
        });
     },
     imagePicker: function() {
       var file_frame;

       $.fn.uploadMediaFile = function( button, preview_media ) {
           var button_id = button.attr('id');
           var field_id = button_id.replace( '_button', '' );
           var preview_id = button_id.replace( '_button', '_preview' );

           // If the media frame already exists, reopen it.
           if ( file_frame ) {
             file_frame.open();
             return;
           }

           // Create the media frame.
           file_frame = wp.media.frames.file_frame = wp.media({
             title: $( this ).data( 'uploader_title' ),
             button: {
               text: $( this ).data( 'uploader_button_text' ),
             },
             multiple: false
           });

           // When an image is selected, run a callback.
           file_frame.on( 'select', function() {
             attachment = file_frame.state().get('selection').first().toJSON();
             $("#" + field_id).val(attachment.id);
             if( preview_media ) {
               $("#" + preview_id).attr('src',attachment.sizes.thumbnail.url);
             }
           });

           // Finally, open the modal
           file_frame.open();
       }

       $('.image_upload_button').click(function() {
           $.fn.uploadMediaFile( $(this), true );
       });

       $('.image_delete_button').click(function() {
           $(this).closest('.input-wrapper').find( '.image_data_field' ).val( '' );
           $( '.image_preview' ).attr('src', '');
           return false;
       });
     }
    }
  };

  $(document).ready(function() {
    customizer.init();
  });

})(jQuery);

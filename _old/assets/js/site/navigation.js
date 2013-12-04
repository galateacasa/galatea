$(document).ready(function() {

  // Navigation controller object
  var nav = {

    nav: $('.nav-main'),
    banner: $('#slides'),
    header: $('.header-main'),
    topFixed: 112,
    topAbsolute: 314,
    fixed: false,

    init: function() {

      // Check if the page have a banner
      if( this.haveBanner() ) this.nav.css('top', this.topAbsolute);

      // Define custom positions
      this.topFixed = this.topFixed;
      this.topAbsolute = this.topAbsolute;
    },

    position: function() {

      if (typeof this.nav.offset() != 'undefined') {
        return this.nav.offset().top - (this.header.height() - 1);
      }

    },

    beFixed: function() {

      if ( !this.fixed && !this.inProduct() ) {
        this.nav.css({'position': 'fixed', 'top': this.topFixed});
        this.fixed = true;
      };

    },

    beAbsolute: function() {
      this.nav.css({'position': 'absolute', 'top': this.topAbsolute});
      this.fixed = false;
    },

    haveBanner: function() {
      return this.banner.length > 0 ? true : false;
    },

    inProduct: function() {

      if ( window.location.href.split('/').indexOf('produto') > 0) {
        return true;
      }else{
        return false;
      }

    }

  }

  // navigation.init();
  nav.init();

  // Listening for browser scroll
  $(window).scroll(function () {

    // Check if the page have a banner and the window scroll if after the banner position
    if( nav.haveBanner() && $(this).scrollTop() < (nav.header.height() + nav.topAbsolute) ) {
      nav.beAbsolute();
    }

    // Check if the window screen position is after the menu position
    if( $(this).scrollTop() >= nav.position() ) {
      nav.beFixed();
    }

  });

});

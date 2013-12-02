$(document).ready(function(){

  // Container that holds the ambiance images
  var ambiance_container = $('#ambiance-objects');

  // Wait until images get loaded
  ambiance_container.imagesLoaded(function() {

    // Pinterest effect
    ambiance_container.masonry({
      itemSelector: '.ambiance-object',
      columnWidth: 300,
      animationOptions: { duration: 400 }
    });

  });

  var loadAmbiances = {

    __area: $('#ambiance-objects'),
    __resultCount: $('#ambiances-result-count'),
    __resultLimit: $('#ambiances-result-limit'),
    __amount: 9,

    init: function() {

      // Listaning for window scroll
      // $(window).bind('mousewheel', function() {

      //   // User is in to the limit height? Have any ambiance to be loaded?
      //   if ( $(window).scrollTop() < $(document).height() ) {

      //     // Define URL
      //     var url = window.location.protocol + '//' + window.location.host;

      //     for (var index = loadAmbiances.__resultLimit.val(); index <= loadAmbiances.__resultLimit.val() + loadAmbiances.__amount; index++) {

      //       if ( !isNaN(index) ) {

      //         $.ajax({
      //           url: url + '/ajax/ambiances/loadMore',
      //           type: 'GET',
      //           dataType: 'HTML',
      //           assync: false,
      //           cache: false,
      //           timeout: 30000,
      //           data: { start: index },
      //           success: function(response) {
      //             if (response != 'vazio') {
      //               loadAmbiances.__area.append(response).masonry('reload');
      //             };
      //           }

      //         });

      //       }

      //     }

      //     loadAmbiances.__resultLimit.val( parseInt( loadAmbiances.__resultLimit.val() ) + this.__amount );

      //   }

      // });

    },

  };

  // loadAmbiances.init();

});

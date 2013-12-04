// Variável de controle da paginação dos items
page = 1;
finished = false;

$(document).ready(function(){
  set_combo_state(false);
  $('#state').change(function(){
    set_combo_city(false, $(this).val());
  });

  // Bind para quando a janela chega com o scroll no final
  $(window).scroll(function() {
    if((($(window).scrollTop() + $(window).height()) >= $(document).height()) && !finished) {
      var currentPage = page;
      page++;
      $.ajax({
        "url": "ajax/home/loadMore",
        "data": {"page": currentPage},
        "type": "post",
        "cache": false,
        "success": function(response) {
          if ($.trim(response)) {
            $('#homeContent').append($.trim(response));
          } else {
            finished = true;
          }
        }
      });
    }
  });
});

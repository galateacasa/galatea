$(document).ready(function(){
  $("#thumbs li img").aeImageResize({ height: 35, width: 100 });

  $('#produce').click(function(){
    return(confirm('Tem certeza que deseja produzir este item?'));
  });
});

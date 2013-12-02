<script type="text/javascript">
$(document).ready(function(){
  //FILE DROP
  var maxUploads = <?php echo $maxUploads?>;
  var maxSize = 2; //mb
  $("#dropbox").filedrop({
    fallback_id: 'upload',
    url: '/upload/',
    paramname: 'image',
    data:{
      path: '<?php echo $path?>'
    },

    error: function(err, file) {
      switch(err) {
       case 'TooManyFiles':
       alert('Muitos arquivos! Selecione no máximo '+maxUploads+'!');
       break;
       case 'FileTooLarge':
       alert(file.name+' é muito grande! Tamanho máximo é de '+maxSize+'mb.');
       break;

       default:
       break;
     }
   },
   maxfiles: maxUploads,
   maxfilesize: maxSize,
   beforeEach: function(file){
    if(!file.type.match(/^image\//)){
     alert('Envie apenas imagens!');
     return false;
   }

   if ($("#uploadResult li").length >= 5) {
     alert("Máximo de "+maxUploads+" uploads");
     return false;
   };
 },
 dragOver: function () {
 },
 drop: function () {
  if($('#image').val()){
    remove_image($('#image').val());
  }
  $("#dropbox").html('<span class="message">Aguarde</span>');
},
afterAll: function () {
  <?
  if ($maxUploads > 1) {
    ?>
    $("#dropbox").html('<span class="message">Imagens salvas com sucesso</span>');
    <?
  }
  ?>
},
uploadFinished: function (i, file, response, time) {
  <?
  if ($maxUploads > 1) {
    ?>
    insert_image_multi(response.file_name);
    <?
  }else{
    ?>
    insert_image(response.file_name);
    <?
  }
  ?>
}
});

function insert_image_multi(image_name){
  var image_url = "<?php echo amazon_url($path)?>/"+image_name;
  $("#uploadResult").append(
    '<li style="cursor:pointer;">'+
    '<div class="thumbnail">'+
    '<img  src="'+image_url+'"><input type="hidden" name="images[]" value="'+image_name+'" />'+
    '<div>'+
    '</li>'
    );

  $("#uploadResult div img").aeImageResize({ height: 30, width: 70 });
}

function insert_image(image_name){
  var image_url = "<?php echo amazon_url($path)?>/"+image_name;
  $("#dropbox").html('<div><img style="cursor:pointer;" src="'+image_url+'"><input type="hidden" id="image" name="image" value="'+image_name+'" /></div>');
  $("#dropbox div img").aeImageResize({ height: 195, width: 205 });
}

$("#dropbox div").live('click', function(){
  if(confirm('Deseja remover a imagem?')){
    remove_image($(this).text());
    $(this).remove();
  }
});

$("#uploadResult div").live('click', function(){
  if(confirm('Deseja remover a imagem?')){
    remove_image($(this).text());
    $(this).remove();
  }
});

function remove_image(image_name){
  jQuery.ajax({
    url: '/upload/delete_image',
    type: 'POST',
    dataType: 'json',
    data: {
      image_name: image_name,
      path: '<?php echo $path?>'
    },
    success: function(data) {
    }
  });
}

<?
foreach($image_insert as $img){
  if ($maxUploads>1) {
    ?>
    insert_image_multi('<?php echo $img?>');
    <?
  }else{
    ?>
    insert_image('<?php echo $img?>');
    <?
  }
}
?>
});
</script>
<?
if ($maxUploads > 1) {
  ?>
  <h3 class="fileupload-title">Imagens</h3>
  <div class="span12" id="dropbox">
    <span class="message">Arraste as imagens para o quadrado principal para incluir as imagens. <br />Para excluir basta clicar nas miniaturas abaixo do quadrando principal.</span>
    <!--<span class="message">Arraste e solte a imagem dentro desta caixa</span>-->
  </div>
  <div id="upload" class="fileupload fileupload-new" data-provides="fileupload">
    <span class="btn btn-file">
      <span class="fileupload-new">Selecione o arquivo</span>
      <span class="fileupload-exists">Selecione o arquivo</span>
      <input type="file" />
    </span>
  </div>
  <ul id="uploadResult" class="thumbnails"></ul>
  <?
}else{
  ?>
  <label class="control-label">Imagem</label>
  <div class="control-group">
   <div id="dropbox" class="span4" style="text-align: center;">
     <span class="message">Arraste e solte a imagem dentro desta caixa</span>
   </div>
 </div>
 <div class="controls">
   <div id="upload" class="fileupload fileupload-new" data-provides="fileupload">
     <span class="btn btn-file"><span class="fileupload-new"></span>
     <span id="change" class="fileupload-exists"></span>
     <input type="file"  name="file" id="file"/></span>
   </div>
 </div>
 <?
}
?>

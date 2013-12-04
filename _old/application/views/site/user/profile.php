<!-- messages + profile information -->
<section class="container_12">
  <section class="grid_12  border-btm">

    <!-- notification -->
    <?php if(count($user_unread_messages) > 0): ?>
      <section id="notifications" class="post-block extra-top-space top-msg_box ">

        <!-- title -->
        <h3><span id="count_msg"></span> </h3>

        <!-- messages -->
        <ul id="content_1">
        </ul> <!-- /messages -->

      </section> <!-- /notification -->
    <?php endif ?>

    <?php echo  $profile_information ?>

  </section>
</section> <!-- /messages + profile information -->

<!-- starred -->
<section class="container_12 border-btm">

  <?php echo  $profile_products ?>
  <?php echo  $profile_projects ?>
  <?php echo  $profile_ambiances ?>

</section>

<!-- friends + messages & reviews -->
<section class="container_12 extra-top-space">
  <section class="grid_12">

    <?php echo  $profile_friends ?>
    <?php echo  $profile_messages ?>

  </section>
</section>
<script>
  function generate(id_message, type_message, template_message) {

    var n = $('section#notifications').noty({
      template : template_message,
      id_message: id_message,
      type_message: type_message,
      type: "notification",
      text: "",
      layout: 'topLeft',
      callback: {
        onShow: function() {},
        afterShow: function() {
          qtd_messages();
        },
        onClose: function() {
          var message_id = n.options.id_message;
          var url = '';
          if(n.options.type_message == 1){
            url = '/ajax/user_messages/setUserMessageRead';
          }else{
            url = '/ajax/items/setItemMessageRead';
          }
          $.ajax({
            type: "POST",
            dataType: "json",
            cache: false,
            url: url,
            data:{message_id: message_id},
            timeout: 2000,
            error: function() {
              console.log("Failed to submit");
            },
            success: function(data) {

            }
          });
        },
        afterClose: function() {
          setTimeout(function(){
            qtd_messages();
          }, 150);
        }
      }
    });
  }

  function qtd_messages()
  {
    var qtd_msgs = $('#notifications li').size();
    var txt = 'Você possui ';

    if(qtd_msgs > 1){
      txt += qtd_msgs+' mensagens';
    }else if(qtd_msgs == 1){
      txt += qtd_msgs+' mensagem';
    }else{
      txt = 'Você não possui mensagens';
    }

    $('#count_msg').text(txt);
  }

  $(document).ready(function() {
    <?php foreach ($user_unread_messages as $user_message): ?>
      generate('<?php echo $user_message["id"]?>', '<?php echo $user_message["type"]?>', '<?php echo $user_message["content"]?>');
    <?php endforeach ?>
  });

</script>

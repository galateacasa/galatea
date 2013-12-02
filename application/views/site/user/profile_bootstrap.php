<?php
$sessionUser = $this->session->userdata('user');
$msgCount = $user_messages->count();
?>
<script type="text/javascript">
$(document).ready(function($) {
  //List messages
  listUserMessages("<?php echo $sessionUser['id']?>");

  $('.alert').live('closed', function(){
    console.log('kkkk');
    setUserMessageRead($(this).attr('message_id'), "<?php echo $sessionUser['id']?>");
  });

  //Send Message
  $('#contact_btn').click(function(){
    if($('#contact_msg').val()){
      var message =  $('#contact_msg').val();
      var user_id = '<?php echo $user->id?>';
      var sender_id = "<?php echo $sessionUser['id']?>";
      sendUserMessage(user_id, sender_id, message);
    }
  });
});
</script>



<div id="user_messages"></div>

<div class="row-fluid" style="margin-left:20px">
  <div class="row">
    <div class="span9 logo">
      <h1><?php echo  $user->name;?> <?php echo $user->voteBtn(); ?></h1>
    </div>

  </div>
  <hr>
  <div class="row ">
    <div class="span4">
      <div class="well sidebar-nav">
        <a href="#" class="thumbnail">
          <?php if ( !empty($user->image) ): ?>
            <img src="<?php echo  amazon_url('images/users/'.$user->image); ?>" alt="<?php echo  $user->name ?>">
          <?php else: ?>
            <img src="http://placehold.it/300x200" alt="">
          <?php endif ?>

        </a>
        <hr>
        <strong><?php echo  role_to_literal($user->role)?></strong>
        <dl class="dl-horizontal">
          <dt>Projetos postados</dt>
          <dd><?php echo  $user->countUserProjects()?></dd>
          <dt>Ambientes postados</dt>
          <dd><?php echo  $user->countUserAmbiances()?></dd>
          <dt>Seguidores</dt>
          <dd><?php echo  $user->countUserVotes()?></dd>
        </dl>
        <hr>

        <!-- Quick Contact form -->
        <ul class="nav nav-list">
          <li class="active"><a href="javascript:"><i class="icon-white icon-envelope"></i> Comente</a></li>
        </ul>
        <br>
        <label><strong>Mensagem :</strong></label>
        <textarea class="" id="contact_msg" rows="3"></textarea>
        <br>
        <button class="btn" id="contact_btn"><i class="icon-envelope"></i> Submit</button>
        <!-- /Quick Contact form -->
      </div><!--/.well -->
    </div><!--/span-->

    <div class="span8">

      <div class="span8">

        <br>
        <div class="row-fluid">
          <p><?php echo  $user->description ?></p>
        </div>
        <br>
      </div><!--/span-->

      <div class="span8">
        <ul class="nav nav-list">
          <li class="active"><a href="javascript:"><i class="icon-white icon-folder-open"></i><strong> Projetos preferidos</strong></a></li>
        </ul>
        <br>
        <div class="row-fluid">
          <?php foreach ($project_votes as $project_vote): ?>
            <div class="span3">
              <a href="#" class="thumbnail">
                <img src="<?php echo amazon_url('images/items/'.$project_vote->item->item_image->get()->image)?>" alt="<?php echo $project_vote->item->name?>">
              </a>
            </div>
          <?php endforeach ?>
        </div>
        <br>
      </div><!--/span-->
      <div class="span8">
        <ul class="nav nav-list">
          <li class="active"><a href="javascript:"><i class="icon-white icon-folder-open"></i><strong> Projetos postados</strong></a></li>
        </ul>
        <br>
        <div class="row-fluid">
          <?php foreach ($projects as $project): ?>
            <div class="span3">
              <a href="#" class="thumbnail">
                <img src="<?php echo amazon_url('images/items/'.$project->item_image->get()->image)?>" alt="<?php echo $project->name?>">
              </a>
            </div>
          <?php endforeach ?>
        </div>
        <br>
      </div><!--/span-->
      <div class="span8">
        <ul class="nav nav-list">
          <li class="active"><a href="javascript:"><i class="icon-white icon-folder-open"></i><strong> Produtos preferidos</strong></a></li>
        </ul>
        <br>
        <div class="row-fluid">
          <?php foreach ($product_votes as $product_vote): ?>
            <div class="span3">
              <a href="#" class="thumbnail">
                <img src="<?php echo amazon_url('images/items/'.$product_vote->item->item_image->get()->image)?>" alt="<?php echo $product_vote->item->name?>">
              </a>
            </div>
          <?php endforeach ?>
        </div>
        <br>
      </div><!--/span-->
      <div class="span8">
        <ul class="nav nav-list">
          <li class="active"><a href="javascript:"><i class="icon-white icon-folder-open"></i><strong> Produtos postados</strong></a></li>
        </ul>
        <br>
        <div class="row-fluid">
          <?php foreach ($products as $product): ?>
            <div class="span3">
              <a href="#" class="thumbnail">
                <img src="<?php echo amazon_url('images/items/'.$product->item_image->get()->image)?>" alt="<?php echo $product->name?>">
              </a>
            </div>
          <?php endforeach ?>
        </div>
        <br>
      </div><!--/span-->
      <div class="span8">
        <ul class="nav nav-list">
          <li class="active"><a href="javascript:"><i class="icon-white icon-folder-open"></i><strong> Ambientes preferidos</strong></a></li>
        </ul>
        <br>

        <div class="row-fluid">
          <?php foreach ($ambiance_votes as $ambiance_vote): ?>
            <div class="span3">
              <a href="#" class="thumbnail">
                <img src="<?php echo amazon_url('images/ambiances/'.$ambiance_vote->ambiance->image);?>" alt="<?php echo $ambiance_vote->ambiance->name?>">
              </a>
            </div>
          <?php endforeach ?>
        </div>
        <br>
      </div><!--/span-->

      <div class="span8">
        <ul class="nav nav-list">
          <li class="active"><a href="javascript:"><i class="icon-white icon-folder-open"></i><strong> Ambientes postados</strong></a></li>
        </ul>
        <br>

        <div class="row-fluid">
          <?php foreach ($ambiances as $ambiance): ?>
            <div class="span3">
              <a href="#" class="thumbnail">
                <img src="<?php echo amazon_url('images/ambiances/'.$ambiance->image);?>" alt="<?php echo $ambiance->name?>">
              </a>
            </div>
          <?php endforeach ?>
        </div>
        <br>
      </div><!--/span-->

      <div class="span8">
        <ul class="nav nav-list">
          <li class="active"><a href="javascript:"><i class="icon-white icon-folder-open"></i><strong> Seguindo</strong></a></li>
        </ul>
        <br>

        <div class="row-fluid">
          <?php foreach ($user_votes as $user_vote): ?>
            <div class="span3">
              <a href="<?php echo  site_url("perfil/{$user_vote->user_voted->username}") ?>" class="thumbnail">
                <img src="<?php echo  amazon_url("images/users/{$user_vote->user_voted->image}"); ?>" alt="<?php echo  $user_vote->user_voted->name ?>">
              </a>
            </div>
          <?php endforeach ?>
        </div>
        <br>
      </div><!--/span-->
      <div class="span8">
        <ul class="nav nav-list">
          <li class="active"><a href="javascript:"><i class="icon-white icon-folder-open"></i><strong> Seguidores</strong></a></li>
        </ul>
        <br>

        <div class="row-fluid">
          <?php foreach ($followers as $follower): ?>
            <div class="span3">
              <a href="<?php echo  site_url("perfil/{$follower->user->username}") ?>" class="thumbnail">
                <img src="<?php echo  amazon_url('images/users/'.$follower->user->image); ?>" alt="<?php echo  $follower->user->name ?>">
              </a>
            </div>
          <?php endforeach ?>
        </div>
        <br>
      </div><!--/span-->

    </div><!--/span-->
  </div><!--/row-->
</form>
</div>
</div>

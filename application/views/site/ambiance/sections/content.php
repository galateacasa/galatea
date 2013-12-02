<?php if( $ambiances->exists() ): /* Check if any ambiance was set */ ?>
    <script>
      <?php if (isset($ambianceId)) { ?>
        window.idShowAmbiance = <?php echo $ambianceId; ?>;
      <?php } else { ?>
        window.idShowAmbiance = false;
      <?php } ?>
    </script>

    <?php foreach($ambiances as $ambiance): /* Lista all ambiances */ ?>

        <!--upload images-->
        <div class="ambiance-object">

            <!-- title -->
            <h2>
                <a ambiance-id="<?php echo $ambiance->id; ?>" href="<?php echo base_url('inspire-me/' . $ambiance->id); ?>" class="ambiance-info">
                    <?php echo  $ambiance->title ?>
                </a>
            </h2>

            <?php echo  $vote_button->get($ambiance->id, 'ambiances', 'star') ?>
            <?php echo  $denounce_button->define('ambiance', $ambiance->id)->get() ?>

            <figure class="ambiance-image">
                <a href="#">
                    <?php echo  img( amazon_url("images/ambiances/{$ambiance->image}") ) ?>
                </a>
            </figure>

            <?php echo  $social_links->get( $ambiance->title, $ambiance->title, amazon_url("images/ambiances/{$ambiance->image}"), base_url("inspire-me/{$ambiance->id}") ) ?>

            <!-- user and category information -->
            <figure class="ambiance-user">

                <!-- user and category description -->
                <figcaption>

                    <!-- user -->
                    <?php echo  anchor("perfil/{$ambiance->user->username}", "{$ambiance->user->name} {$ambiance->user->surname}" ) ?>

                    <!-- category -->
                    <mark>
                        <?php echo  anchor("inspire-me/?category={$ambiance->category->id}", "{$ambiance->category->name}" ) ?>
                    </mark>

                </figcaption> <!-- /user and category description -->

                <!-- user image -->
                <a href="<?php echo  base_url("perfil/{$ambiance->user->username}") ?>">
                    <?php echo  img( amazon_url("images/users/{$ambiance->user->image}", 60, 60) ) ?>
                </a> <!-- /user image -->

            </figure>

        </div>

    <?php endforeach ?>

<?php endif; ?>

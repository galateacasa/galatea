    <!--footer start here-->
    <footer class="footer-main">
      <section class="container_12">
        <section class="grid_12">
          <?php $this->load->view('site/common/footer/about-links') ?>
          <?php $this->load->view('site/common/footer/social-network') ?>
          <?php $this->load->view('site/common/footer/newsletter') ?>
        </section>
      </section>
    </footer> <!--footer ends here-->

    <?php

      // Define default scripts that need to be included into document
      $defaultScripts = array(
        'plugins/jquery.ae.image.resize.min',
        'plugins/slides.min.jquery',
        'plugins/mCustomScrollbar',
        'plugins/jquery.validate',
        'plugins/jquery.maskMoney',

        'plugins/noty/jquery.noty',
        'plugins/noty/layouts/bottom',
        'plugins/noty/layouts/bottomCenter',
        'plugins/noty/layouts/bottomRight',
        'plugins/noty/layouts/center',
        'plugins/noty/layouts/centerLeft',
        'plugins/noty/layouts/centerRight',
        'plugins/noty/layouts/inline',
        'plugins/noty/layouts/top',
        'plugins/noty/layouts/topLeft',
        'plugins/noty/layouts/topRight',
        'plugins/noty/layouts/topCenter',
        'plugins/noty/themes/default',

        'plugins/customSelect.jquery',
        'plugins/customInput.jquery',
        'plugins/jquery.fileinput',
        'site/upload_box',
        'site/Modernizr.custom.min',
        'site/Vote',
        'site/Denounce',
        'site/Dropdown',
        'site/Message',
        'site/Placeholder',
        'site/sticky-float',
        'site/tooltip',
        'site/util',
        'site/header',
        'site/navigation',
        'site/VerticalSlider',
        'site/HorizontalSlider'
      );

      // Any aditional script needs to be added?
      if ( isset($scripts) ) {

        if ( is_array($scripts) ) {
          $defaultScripts = array_merge($defaultScripts, $scripts);
        }else{
          $defaultScripts[] = $scripts;
        }

      }

      // Include all scripts
      foreach($defaultScripts as $defaultScript)
        printf('<script src="%s?v=%s"></script>', base_url("/assets/js/$defaultScript.js"), VERSION);

    ?>

    <script>

      $(document).ready(function() {

        // Create a new Vote instance
        new Vote();

        // Create a new Denounce instance
        new Denounce("<?php echo  $this->session->userdata('id') ?>");

        // Message and reviews areas
        new Message("<?php echo  $this->session->userdata('id') ?>");

        // Create a new Placeholder instance
        new Placeholder();

        $("#slides div img").aeImageResize({ height: 203, width: 940 });

        $("#slides").slides({
          fadeSpeed: 350,
          play: 5000,
          effect:'fade'
        });

        $('.back-top-top').click(function(){
          $("html,body").animate({scrollTop:0},500)
        });

        $('.four-icons').stickyfloat();

        $('.social-icon li a').click(function(e){
          e.preventDefault();
          var specs = 'width=600,height=400';
          var url   = $(this).attr('data-url');
          var img = $(this).parent().parent().prev().children().children().attr('src');
          if($(this).attr('data-alert') == "true"){
            alert(url);
          }else{
            window.open(url,'',specs);
          }
        });

        //Money fields mask
        $('.money').maskMoney({
          symbol:'R$ ',
          thousands:'.',
          decimal:',',
          symbolStay: true
        });

        //Notifications
        function generate_noty(type, msg, layout, timeout) {
          var n = noty({
            text: msg,
            type: type,
            dismissQueue: true,
            layout: layout,
            timeout: timeout
          });
        }

        <?php if($this->session->flashdata('error') || $this->session->flashdata('success')): ?>

          <?php
            $type = $this->session->flashdata('error') ? "error" : "success";

            $msg = str_replace( array("\r\n", "\r", "\n"), "", $this->session->flashdata($type) );
          ?>

          generate_noty("<?php echo  $type?>", "<?php echo  $msg ?>", 'topLeft', 9000);

        <?php endif ?>

      });

    </script>

    <!-- Facebook plugin mark up -->
    <div id="fb-root"></div>

    <?php if (ENVIRONMENT == 'production'): /* We are at production server? */ ?>
      <script>
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-25122440-2']);
        _gaq.push(['_trackPageview']);

        (function() {
          var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
          ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
          var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();
      </script>
    <?php endif ?>

  </body>

</html>

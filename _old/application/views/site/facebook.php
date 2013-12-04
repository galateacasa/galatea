<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <body>
    <div id="fb-root"></div>
    <script>

      window.fbAsyncInit = function() {

        FB.init({
          appId: '<?php echo  $facebook->getAppID() ?>',
          cookie: true,
          xfbml: true,
          oauth: true
        });

        FB.getLoginStatus(function(response) {
          if (response.status === 'connected') {
            window.location.href = '<?php echo  site_url("login/facebook_callback") ?>';
          } else { // not logged
            window.location.href = '<?php echo  isset($loginUrl) ? $loginUrl : '' ?>';
          }
        });

      };

      (function() {
        var e = document.createElement('script'); e.async = true;
        e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
        document.getElementById('fb-root').appendChild(e);
      }());

    </script>
  </body>
</html>

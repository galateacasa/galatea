<!-- newsletter + copyright + back to top -->
<aside>

  <!-- title -->
  <h4>NewsLetter</h4>

  <!-- newsletter + back to top -->
  <div class="inpt-out">

    <!-- newsletter -->
    <?php echo  form_open('site/home/newsletter') ?>
      <input class="button-newsletter float-l" type="text" placeholder="e-mail" name="email" >
      <input type="submit" class="button float-r" value="OK">
    <?php echo  form_close() ?>

    <!-- back to top -->
    <a href="#top" class="back-top-top" onmouseover="tooltip.show('voltar ao topo');" onmouseout="tooltip.hide();">&nbsp;</a>

  </div>

  <!-- copyright -->

  <em>Galatea Casa &#169; Todos os direitos reservados.</em>
</aside> <!-- /newsletter + copyright + back to top -->

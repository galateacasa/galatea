<section class="grid_9 omega product-top alpha omega bank-ac-form">
  <div class="block extra-btm-space">
    <h2 class="extra-btm-space extra-top-space">dados de pagamento</h2>
    <h3 class="small-caps">Você acumulou<em>R$ <?php echo number_format($user->getUserCredits(), 2, ',', '.')?></em></h3>
    <h3>Você pode resgatar seus créditos ao fechar o carrinho de compra, ou através de depósito bancário. neste caso, será necessário informar seus dados bancários e enviar um nota fiscal no valor resgatado.</h3>
  </div>
  <form action="" method="POST" enctype="multipart/form-data">
    <div class="block text-big">
      <div class="block extra-btm-space tex">
        <input type="text" name="value" id="value"  class="search-area float-l mid-text-box no-bg-img alpha" placeholder="Valor a ser resgatado">
      </div>

      <div class="block extra-btm-space">
        <input type="text" name="name" id="name" class="search-area float-l no-bg-img  grid_5 alpha"  placeholder="nome do titular mesmo da nota fiscal">
      </div>

      <div class="block extra-btm-space">
        <input type="text" id="cnpj" name="cnpj" class="search-area float-l no-bg-img  grid_4 alpha"  placeholder="cnpj">
      </div>

      <div class="block extra-btm-space">
        <input type="text" id="bank" name="bank" class="search-area float-l mid-text-box no-bg-img  alpha"  placeholder="banco">
        <input type="text" id="account" name="account" class="search-area float-l no-bg-img mid-text-box alpha" placeholder ="Conta corrente">
        <input type="text" id="agency" name="agency" class="search-area float-l no-bg-img mid-text-box  alpha omega"  placeholder="agência">
      </div>
    </div>

    <div class="block">
      <p class="cap-caps bold-text">Faça o upload da sua nota fiscal. o valor da nota deve ser o mesmo descrito acima.</p>
      <div class="file-submit file-upload-inline">
        <input type="file" name="fiscal" id="fiscal" />
      </div>
    </div>

    <section class="grid_9 float-r accept-terms omega">
      <input type="submit" class="link-btn blue float-r small-link " value="resgatar">
      <span class="grid_6 terms-con alpha float-r">
        <em class="cap-caps">Confira os dados.</em> Após a confirmação essa operação não poderá ser cancelada. Ao clicar no botão ao lado, você atesta a veracidade e acuracidade dos dados. A transferência não será refeita no caso de erro de digitação, de acordo com Termos de Uso do site.
      </span>
    </section>
  </form>

</section>

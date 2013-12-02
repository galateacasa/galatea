<style>
   .main-content {
    background: #none;

    padding-bottom: 50px;

    -webkit-shadow: none;
       -moz-shadow: none;
          shadow: none;
  }

   .main-content label {
    text-transform: uppercase;
  }

   .main-content input[type=text],
   .main-content textarea {
    min-width: 300px;
    padding: 10px;
    text-transform: none;
  }

   .main-content > p {
    padding: 15px 0;
  }

   .images figure {
    position: relative;
  }

   .images {
    margin: 0 0 80px;
  }

   figure {
    padding: 30px 0 50px;
  }
   figure img {
    width: 100%;
  }

   .images .info a,
   .images .info p {
      color: #fff;
      text-decoration: none;
  }

   .images .info {
      position: absolute;
      background: #23adf4;
      color: #fff;
      padding: 10px 10px 5px;

      width: 150px;

      right: 0;
      bottom: 0;
  }
     .images figure .info:before {
        content: '';
        position: absolute;
        top: 0; right: 0;
        border-top: 10px solid #f0f2ef;
        border-left: 10px solid #23adf4;
        width: 0;
    }



     .images .info h3 {
      text-transform: uppercase;
      font-weight: 300;
      font-size: 13px;
      padding-bottom: 10px;
      margin-bottom: 7px;
      border-bottom: 1px solid #fff;
    }
     .images .info p {
      font-size: 11px;
      font-family: Georgia;
      font-weight: normal;
      font-style: italic;
    }
     .images figure .info .plus {
      float: right;
      margin: -18px 0 0;
      padding: 3px 3px 0;
      font-size: 14px;
    }

     form section {
      margin: 10px 0;
    }

     input[type=text] {
      width: 320px;
      margin-right: 6px;
    }

     form label {
      padding-bottom: 10px;
      display: block;
    }

     form textarea {
      height: 160px;
    }

     .accept-terms span {
      padding-top: 10px;
    }
</style>


<section class="container_12">

    <section class="grid_12 main-content">
      <h2>CONCURSO CULTURAL GALATEA CASA</h2>
      <p>Escreva seu nome e email e responda: Por que voc&#234; merece ganhar um m&#243;vel exclusivo Galatea Casa?<br />
         As 3 respostas mais originais ser&#227;o premiadas, cada uma, com um dos produtos abaixo.<br />
         Divulgaremos o vencedor no dia 20/01/14 em nosso <a href="http://blog.galateacasa.com.br" target="_blank">blog</a> e <a href="http://www.facebook.com/GalateaCasa" target="_blank">Facebook</a>. Participe!<br /></p>
      <section class="images grid_12">
        <figure class="grid_4 alpha">
          <div class="info">
            <h3>
              <a href="http://www.galateacasa.com.br/produto/carrinho-de-cha-natura">Carrinho de ch&aacute; Grilli</a>
            </h3>
            <p><a href="http://www.galateacasa.com.br/produto/carrinho-de-cha-natura">Vers&#227;o premiada de um m&#243;vel multiuso</a></p>
            <a href="http://www.galateacasa.com.br/produto/carrinho-de-cha-natura" class="plus">+</a>
          </div>
          <a href="http://www.galateacasa.com.br/produto/carrinho-de-cha-natura" target="_blank"><img src="assets/images/landing/carrinho_de_cha.png" alt="" /></a>
        </figure>
        <figure class="grid_4">
          <div class="info">
            <h3>
              <a href="http://www.galateacasa.com.br/produto/cadeira-palhinha-sem-braco">Cadeira Palhinha</a>
            </h3>
            <p><a href="http://www.galateacasa.com.br/produto/cadeira-palhinha-sem-braco">Contemporaneidade e alma brasileira</a></p>
            <a href="http://www.galateacasa.com.br/produto/cadeira-palhinha-sem-braco" class="plus">+</a>
          </div>
          <a href="http://www.galateacasa.com.br/produto/cadeira-palhinha-sem-braco" target="_blank"><img src="assets/images/landing/cadeira_jantar_palhinha.png" alt="" /></a>
        </figure>
        <figure class="grid_4 omega">
          <div class="info">
            <h3>
              <a href="http://www.galateacasa.com.br/produto/criado-mudo-vintag">Criado-mudo Vintage</a>
            </h3>
            <p><a href="http://www.galateacasa.com.br/produto/criado-mudo-vintag">Design vintage com estilo contempor&#226;neo</a></p>
            <a href="http://www.galateacasa.com.br/produto/criado-mudo-vintag" class="plus">+</a>
          </div>
          <a href="http://www.galateacasa.com.br/produto/criado-mudo-vintag" target="_blank"><img src="assets/images/landing/criado_mudo_vintage.png" alt="" /></a>
        </figure>
      </section>
      <form action="" class="">
        <section class="grid_11 alpha">
                <input id="inputNome" type="text" name="nome" placeholder="Nome" />
                <input id="inputEmail" type="text" name="email" placeholder="Email" />
            </section>
            <section class="grid_12 alpha">
                <label for="msg">POR QUE VOC&#202; MERECE GANHAR UM M&#211;VEL EXCLUSIVO GALATEA CASA?</label>
                <div id="charNum"></div>
                <textarea name="msg" id="msg" placeholder="Resposta"></textarea>
            </section>

        <section class="grid_5 float-r accept-terms">
          <button id="btnSubmit" type="submit" class="button float-r">Enviar</button>
          <span class="grid_3 terms-con alpha float-r">Clicando em ENVIAR, voc&#234; concorda com os <a href="http://www.galateacasa.com.br/institucional/concurso-cultural-abril" target="_blank">Termos e condi&ccedil;&otilde;es da promo&ccedil;&atilde;o</a>.</span>
        </section>

      </form>

    </section>

</section>
<script>
$(function() {
  $("#btnSubmit").click(function(event) {
    event.preventDefault();

    var name = $.trim($("#inputNome").val());
    var email = $.trim($("#inputEmail").val());
    var reason = $.trim($("#msg").val());

    if (name && email && reason) {
      $.post('ajax/email/abril', {
        'name': name,
        'email': email,
        'reason': reason
      }, function() {
          alert('Sua entrada no concurso foi efetuada com sucesso.');
          window.location = 'http://www.galateacasa.com.br';
      });
    } else {
      alert('Preencha todos os campos corretamente.');
    }
  });
});
</script>

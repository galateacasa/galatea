<section class="about">
  <h2>SOBRE A GALATEA</h2>

  <h3>O que é a GALATEA?</h3>

  <p>GALATEA é um novo modelo no mercado da alta movelaria. Criando o menor caminho entre quem cria e quem consome, conseguimos eliminar vários custos desnecessários para entregar móveis de qualidade na sua casa. E o melhor: com a mesma qualidade das lojas de alto padrão mas a um preço até seis vezes menor.</p>

  <h3>Como funciona?</h3>

  <p>De uma boa ideia a um móvel de qualidade:</p>

  <ol>
  <li>Designers apresentam suas melhores ideias à GALATEA;</li>
  <li>As mais interessantes vão à votação do público;</li>
  <li>O público escolhe o seu design preferido;</li>
  <li>A GALATEA investe no projeto, faz protótipos e o transforma em produto;</li>
  <li>Fornecedores se preocupam apenas em produzir. A GALATEA faz pedidos “on demand”, a risco zero;</li>
  <li>O designer tem seu trabalho produzido e recebe royalties a cada peça vendida;</li>
  <li>O público tem a chance de comprar um móvel de qualidade de acordo com o seu gosto e a um preço muito mais vantajoso do que encontraria numa loja convencional.</li>
  </ol>


  <h3>Me dê cinco motivos para comprar na GALATEA.</h3>

  <ol>
  <li>Sob demanda. Sem o risco de estoques “encalhados”, o preço cai.</li>
  <li>Online. Sem o custo de uma loja física, o preço cai.</li>
  <li>Qualidade. Sempre escolhemos os melhores materiais e os fabricantes mais qualificados para cada tipo de móvel.</li>
  <li>Design. O próximo grande nome do design pode estar aqui. Fique de olho.</li>
  <li>Eficiência. Nosso processo baseado em crowdsourcing aproveita conhecimentos coletivos para criar conceitos e soluções inteligentes para nossos móveis. Várias cabeças pensam melhor que uma.</li>
  </ol>


  <h3>Por que o nome GALATEA?</h3>

  <p>Vem do mito do rei Pigmaleão, que um dia decidiu esculpir a mulher ideal. Pigmaleão caprichou tanto e criou uma mulher tão linda, mas tão linda, que ele logo se apaixonou perdidamente pela estátua. Mas, claro, o rei não era feliz ao lado de uma pedra. Pedia aos deuses que um dia ela ganhasse vida. Atendendo às preces, a Deusa Afrodite transformou GALATEA em mulher de carne e osso. Os dois se casaram e tiveram um filho.</p>

  <p>Assim como no mito, nós da GALATEA temos como missão a busca pelo design ideal e nosso grande objetivo é dar vida aos melhores projetos de móveis. Para tanto, não contamos com os poderes de Afrodite, mas com a sua colaboração no modelo <?php echo  anchor('http://pt.wikipedia.org/wiki/Crowdsourcing', 'crowdsourcing') ?>.</p>

  <h2>ENVIE SEU PROJETO</h2>

  <h3>O que devo fazer para enviar um projeto meu?</h3>

  <?php if( $this->session->userdata('id') ): ?>
    <p>Envie sua ideia <?php echo  anchor('criar-projeto', 'aqui') ?>.</p>
  <?php else: ?>
    <p>Cadastre-se no site e envie sua ideia.</p>
  <?php endif ?>

  <h3>Como funciona o processo de seleção?</h3>

  <p>Todos os projetos são avaliados pela Curadoria GALATEA, um time que analisa a viabilidade de produção e de potencial de mercado de cada ideia. A Curadoria é quem decide se o projeto seguirá para a próxima etapa: a votação do público. <?php echo  anchor('institucional/designer', 'Saiba mais') ?>.</p>

  <h2>COMPRE NA GALATEA</h2>

  <h3>Quais meios de pagamento a GALATEA aceita?</h3>

  <p>A GALATEA trabalha com os seguintes meios de pagamento:
  Cartões de crédito: parcelamento em até 10 vezes;
  Débito bancário: faça o pagamento diretamente em sua conta corrente;
  Boleto bancário: imprima e pague no banco mais próximo, ou digite o código de barras em seu internet banking.
  Todos os móveis tem garantia de 6 meses?</p>

  <p>Sim! Você encontra os detalhes e condições nesta página. [linkar para página da garantia]</p>

  <h3>A troca e a devolução são gratuitas?</h3>

  <p>Sim! Assim você compra com segurança. <?php echo  anchor('institucional/trocas-e-devolucoes', 'Leia os detalhes aqui') ?>.</p>

  <h2>GANHE DINHEIRO COM A GALATEA</h2>

  <h3>Como posso ganhar dinheiro com a GALATEA?</h3>

  <p>Você pode ganhar dinheiro de duas formas:</p>

  <ul>
  <li>ganhe 1% de comissão a cada venda que você gerar. Na galeria Inspire-me, você posta imagens de ambientes decorados e sugere móveis da GALATEA que poderiam compor esse ambiente. Se alguém gostar da sua sugestão e ela inspirar uma compra no site, você ganha 1% do valor da venda.</li>
  <li>ganhe 5% de royalties do valor de cada produto seu vendido no site. Envie seu projeto para a gente. Se ele for aprovado e ganhar a votação [linkar para página Vote], a GALATEA cuidará de todo o processo: prototipagem, produção, comercialização e distribuição do seu produto. Você receberá royalties de acordo com as vendas. <?php echo  anchor('institucional/designer', 'Saiba mais') ?>.</li>
  </ul>


  <p>O valor gerado pode ser utlizado como crédito para compras no site ou você pode resgatá-lo por meio de transferência bancária. Neste último caso, é necessário o envio de uma nota fiscal ou RPA (recibo de pagamento a autônomo).</p>

  <h3>O que é o Inspire-me?</h3>

  <p>No <?php echo  anchor('ambiances', 'Inspire-me') ?>, promovemos o compartilhamento de boas soluções de decoração entre os usuários do site. Dê uma olhada na galeria de ambientes decorados e aproveite as sugestões na sua casa. Você também pode incluir suas próprias sugestão - se alguém comprar um produto GALATEA inspirado no seu ambiente, você ganha uma comissão de 1% do valor da venda.</p>

  <h3>Como faço para incluir imagens no site?</h3>

  <p>Procure pelo botão “Enviar” no topo do site e escolha a opção “Enviar ambiente”. Depois de carregar a sua imagem, não se esqueça de anexar os produtos GALATEA que ficariam bem naquele ambiente. Vale lembrar que você deve usar apenas imagens sobre as quais possui os direitos.</p>

  <h3>Como sei que tenho créditos na GALATEA?</h3>

  <p>Basta dar uma olhada <?php echo  $this->session->userdata('id') ? anchor('perfil/' . $this->session->userdata('id'), 'no seu perfil') : 'no seu perfil' ?>. Ali você pode acompanhar quais foram as imagens que inspiraram outras pessoas, e o valor que você tem em descontos na GALATEA. Você também receberá um email sempre que um novo crédito aparecer na sua conta.</p>

  <h2>PRODUZA MÓVEIS PARA A GALATEA</h2>

  <h3>Sou fabricante de móveis. Como faço para trabalhar com a GALATEA?</h3>

  <p>Procuramos fornecedores sérios para atender a clientes em todo o Brasil. Cadastre-se no site e receba por email notificações de novos projetos. <?php echo  anchor('institucional/fornecedor', 'Saiba mais aqui') ?>.</p>
</section>

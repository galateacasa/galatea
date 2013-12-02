<p style="font-size: 14px; color: #51534c; font-family: Georgia, Serif;">Oi <?php echo  $name ?>,</p>
<br />
<p style="font-size: 14px; color: #51534c; font-family: Georgia, Serif;">Uma &oacute;tima not&iacute;cia: o pedido <?php echo  $number ?> est&aacute; a caminho da sua casa.</p>
<br />
<p style="font-size: 14px; color: #51534c; font-family: Georgia, Serif;">Estes foram os itens entregues para a transportadora no dia <?php echo  $date ?>.</p>
<br />
<table>
  <thead>
    <tr>
      <td>Item<td/>
      <td>Designer</td>
      <td>Valor</td>
    </tr>
  </thead>
  <tbody>
<?
foreach ($items as $item) {
?>
    <tr>
      <td><?php echo  $item['name'] ?></td>
      <td><?php echo  $item['designer'] ?></td>
      <td><?php echo  $item['value'] ?></td>
    </tr>
<?
}
?>
  </tbody>
</table>
<br />
<p style="font-size: 14px; color: #51534c; font-family: Georgia, Serif;">O pedido deve chegar em at&eacute; sete dias &uacute;teis. Nossa transportadora entrar&aacute; em contato com voc&ecirc; para combinar a melhor data de entrega dentro desse per&iacute;odo.</p>
<br />
<p style="font-size: 14px; color: #51534c; font-family: Georgia, Serif;">O pedido ser&aacute; entregue no endere&ccedil;o abaixo:</p>
<br />
<p style="font-size: 14px; color: #51534c; font-family: Georgia, Serif;">Destinat&aacute;rio: Luiz Lopes</p>
<br />
<p style="font-size: 14px; color: #51534c; font-family: Georgia, Serif;">Rua de Valinhos, 500</p>
<br />
<p style="font-size: 14px; color: #51534c; font-family: Georgia, Serif;">Bairro x - Valinhos</p>
<br />
<p style="font-size: 14px; color: #51534c; font-family: Georgia, Serif;">SP - CEP: 00000-000</p>
<br />
<p style="font-size: 14px; color: #51534c; font-family: Georgia, Serif;">Algumas informa&ccedil;&otilde;es importantes sobre a nossa pol&iacute;tica de entrega:</p>
<br />
<p style="font-size: 14px; color: #51534c; font-family: Georgia, Serif;">- Nossas transportadoras n&atilde;o est&atilde;o autorizadas a retirar m&oacute;veis antigos. Por favor, garanta que o espa&ccedil;o que receber&aacute; seu m&oacute;vel Galatea esteja desocupado na data da entrega;</p>
<br />
<p style="font-size: 14px; color: #51534c; font-family: Georgia, Serif;">- Ser&atilde;o realizadas duas tentativas de entrega. Em caso de insucesso, a mercadoria volta para o Centro de Distribui&ccedil;&atilde;o da Galatea. Ser&aacute; cobrado um novo frete na re-entrega;</p>
<br />
<p style="font-size: 14px; color: #51534c; font-family: Georgia, Serif;">- Nossas transportadoras n&atilde;o est&atilde;o autorizadas a realizar a entrega por meios &quot;alternativos&quot; (cordas, janelas, telhado, etc);</p>
<br />
<p style="font-size: 14px; color: #51534c; font-family: Georgia, Serif;">- A entrega pode ser realizada para terceiros, como parentes e porteiros, desde que estejam autorizados pelo comprador a receber a mercadoria e mediante assinatura do comprovante de entrega e apresenta&ccedil;&atilde;o de documento;</p>
<br />
<p style="font-size: 14px; color: #51534c; font-family: Georgia, Serif;">- Por favor, recuse a entrega caso a embalagem n&atilde;o esteja em condi&ccedil;&otilde;es adequadas ou existam sinais de avaria. Antes de assinar pelo recebimento do produto, abra a embalagem e se certifique de que ele est&aacute; em perfeitas condi&ccedil;&otilde;es. Avise a Galatea sobre qualquer diverg&ecirc;ncia no prazo m&aacute;ximo de sete dias pelo email atendimento@galateacasa.com.br.</p>
<br />
<p style="font-size: 14px; color: #51534c; font-family: Georgia, Serif;">- Recomendamos preservar a nota fiscal dos produtos. Ela ser&aacute; necess&aacute;ria caso seja constatado algum defeito ou em caso de trocas e devolu&ccedil;&otilde;es.</p>
<br />
<p style="font-size: 14px; color: #51534c; font-family: Georgia, Serif;">Para mais informa&ccedil;&otilde;es, verifique nossa <?php echo  anchor('institucional/trocas-e-devolucoes', 'Pol&iacute;tica de Troca e Devolu&ccedil;&atilde;o') ?>. Sempre que precisar, fale conosco pelo email atendimento@galateacasa.com.br.</p>
<br />
<p style="font-size: 14px; color: #51534c; font-family: Georgia, Serif;">Obrigado por fazer parte da Galatea!</p>
<br />
<p style="font-size: 14px; color: #51534c; font-family: Georgia, Serif;">Time Galatea Casa</p>
<p style="font-size: 14px; color: #51534c; font-family: Georgia, Serif;"><?php echo  anchor('http://www.galateacasa.com.br', 'http://www.galateacasa.com.br') ?></p>

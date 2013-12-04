var variationsForm = {};
$(document).ready(function(){
  variationsForm = $("#variations").sheepIt({
    separator: '',
    allowRemoveLast: true,
    allowRemoveCurrent: true,
    allowRemoveAll: true,
    allowAdd: true,
    allowAddN: true,
         
    // Limits
    maxFormsCount: 5,
    minFormsCount: 0,
    iniFormsCount: 0,
    nestedForms: [
    {
      id: 'variations_#index#_values',
      options: { 
        indexFormat: '#index_values#',
        maxFormsCount: 5
      }
    }
    ]
         
  });
});


$('#production_price').autoNumeric('init');
$('.variation').autoNumeric('init');
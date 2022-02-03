const html_cargando = `<div class="modal-body text-center">
<div class="spinner-border text-dark" role="status">
  <span class="visually-hidden">Loading...</span>
</div>
<span>&nbsp; Cargando...</span>
</div>`;
let xhr;

$("#modal").on('show.bs.modal', function (event) {
  const button = event.relatedTarget;
  const modal = this;
  const url = $(button).data('url');
  if(url){
      const size = $(button).data('size') ? $(button).data('size') : 'modal-md';
      $(modal).find(".modal-dialog").removeClass("modal-lg").removeClass("modal-sm").removeClass("modal-md");
      $(modal).find(".modal-dialog").addClass(size);
      $.ajax({
          type: "GET",
          url: url,
          beforeSend: function (data) {
              $(modal).find(".modal-content").html(html_cargando);
          },
          success: function (data) {
              $(modal).find(".modal-content").html(data);
          },
          error: function (responseText, textStatus, errorThrown) {
              console.log("readyState: " + responseText.readyState);
              console.log("responseText: " + responseText.responseText);
              console.log("status: " + responseText.status);
              console.log("text status: " + textStatus);
          }
      });
  }
  
});
$("#modal").on('show.bs.modal', function (event) {
    $(this).find(".modal-content").html(html_cargando);
});

$(document).ready(function(){
    jQuery.extend(jQuery.validator.messages, {
    required: "Este campo es obligatorio.",
    remote: "Por favor, rellena este campo.",
    email: "Por favor, escribe una dirección de correo válida",
    url: "Por favor, escribe una URL válida.",
    date: "Por favor, escribe una fecha válida.",
    dateISO: "Por favor, escribe una fecha (ISO) válida.",
    number: "Por favor, escribe un número entero válido.",
    digits: "Por favor, escribe sólo dígitos.",
    creditcard: "Por favor, escribe un número de tarjeta válido.",
    equalTo: "Por favor, escribe el mismo valor de nuevo.",
    accept: "Por favor, escribe un valor con una extensión aceptada.",
    maxlength: jQuery.validator.format("Por favor, no escribas más de {0} caracteres."),
    minlength: jQuery.validator.format("Por favor, no escribas menos de {0} caracteres."),
    rangelength: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
    range: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1}."),
    max: jQuery.validator.format("Por favor, escribe un valor menor o igual a {0}."),
    min: jQuery.validator.format("Por favor, escribe un valor mayor o igual a {0}.")
    });    
});
<form action="?c=Producto&a=Store" id="frmCrearProducto">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="col-md-6">
                <label for="referencia" class="form-label">Referencia</label>
                <input type="text" class="form-control" id="referencia" name="referencia" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="precio" class="form-label">Precio</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="text" class="form-control" id="precio" name="precio" required>
                </div>
            </div>
            <div class="col-md-6">
                <label for="stock" class="form-label">Stock</label>
                <input type="text" class="form-control" id="stock" name="stock" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="peso" class="form-label">Peso</label>
                <input type="text" class="form-control" id="peso" name="peso" required>
            </div>
            <div class="col-md-6">
                <label for="categoria" class="form-label">Categoria</label>
                <select class="form-select" id="categoria" name="categoria">
                    <option value="Alimentos">Alimentos</option>
                    <option value="Bebidas">Bebidas</option>
                    <option value="Mecatos">Mecatos</option>
                    <option value="Papeleria">Papeleria</option>
                </select>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-dark" id="btnGuardar">Guardar</button>
    </div>
</form>
<script>
$("#frmCrearProducto").validate({
    focusInvalid: true,
    errorPlacement: function (error, element) {
        $(element).siblings('.invalid-feedback').remove();
      $(element).addClass("is-invalid"); 
      $(element).after(`<div class="invalid-feedback">${error.text()}</div>`);
    },
    success: function (label) {
        $("#frmCrearProducto").find("#"+$(label).attr("for")).removeClass('is-invalid'); 
        $("#frmCrearProducto").find("#"+$(label).attr("for")).siblings('.invalid-feedback').remove();
    }
});

$("#frmCrearProducto").submit(function (e) {
  e.preventDefault();
  if($("#frmCrearProducto").valid()){
    if(xhr){
        xhr.abort();
        xhr = null;
    }
    xhr = $.ajax({
      url:"?c=Productos&a=Store",
      method:"post",
      data:$("#frmCrearProducto").serialize(),
      dataType: "json",
      error: function (jqXHR, exception) {
          console.log("jqXHR",jqXHR.responseText);
          console.log("exception",exception);
      },
      success:function(response){
          if(response.result){
              location.reload();
          }
      }
    });
  }
})
</script>
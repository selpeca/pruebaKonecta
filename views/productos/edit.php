<form action="?c=Producto&a=Update" id="frmEditarProducto">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required value="<?= $producto->nombre ?>">
            </div>
            <div class="col-md-6">
                <label for="referencia" class="form-label">Referencia</label>
                <input type="text" class="form-control" id="referencia" name="referencia" required value="<?= $producto->referencia ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="precio" class="form-label">Precio</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="text" class="form-control" id="precio" name="precio" required value="<?= $producto->precio ?>">
                </div>
            </div>
            <div class="col-md-6">
                <label for="stock" class="form-label">Stock</label>
                <input type="text" class="form-control" id="stock" name="stock" required value="<?= $producto->stock ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="peso" class="form-label">Peso</label>
                <input type="text" class="form-control" id="peso" name="peso" required value="<?= $producto->peso ?>">
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
        <input type="hidden" name="id" value="<?= $producto->id ?>"/>
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-dark" id="btnGuardar">Guardar</button>
    </div>
</form>
<script>
$("#categoria option[value='<?= $producto->categoria ?>']").prop("selected",true)
$("#frmEditarProducto").validate({
    focusInvalid: true,
    errorPlacement: function (error, element) {
        $(element).siblings('.invalid-feedback').remove();
      $(element).addClass("is-invalid"); 
      $(element).after(`<div class="invalid-feedback">${error.text()}</div>`);
    },
    success: function (label) {
        $("#frmEditarProducto").find("#"+$(label).attr("for")).removeClass('is-invalid'); 
        $("#frmEditarProducto").find("#"+$(label).attr("for")).siblings('.invalid-feedback').remove();
    }
});

$("#frmEditarProducto").submit(function (e) {
  e.preventDefault();
  if($("#frmEditarProducto").valid()){
    if(xhr){
        xhr.abort();
        xhr = null;
    }
    xhr = $.ajax({
      url:"?c=Productos&a=Update",
      method:"post",
      data:$("#frmEditarProducto").serialize(),
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
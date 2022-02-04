<form id="frmAgregarVenta" action="?c=Ventas&a=Store" method="POST" autocomplete="off">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom pt-4">
        <h3>Nueva venta</h3>
        <div class="btn-toolbar mb-2 mb-md-0">
            <button type="button" class="btn btn-dark" onclick="guardarVenta();"><i class="bi bi-save"></i> Guardar venta</button>
        </div>
    </div>
    <div id="alerta_supera" class="alert alert-warning d-flex align-items-center alert-dismissible d-none" role="alert">
        <div>
            <p>La cantidad supera el stock disponible (<span></span>)</p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div id="alerta_sin_productos" class="alert alert-warning d-flex align-items-center alert-dismissible d-none" role="alert">
        <div>
            <p>Favor agregar productos</p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div class="form-floating mb-3">
        <input type="date" class="form-control" id="fec_venta" name="fec_venta" required>
        <label for="fec_venta">Fecha</label>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>
                    <select class="form-select" id="producto">
                        <?php foreach ($productos as $producto) { ?>
                            <option
                                value="<?= $producto->id?>"
                                data-stock="<?= $producto->stock ?>"
                                data-precio="<?= $producto->precio ?>"
                            ><?= $producto->nombre ?></option>
                        <?php } ?>
                    </select>
                </th>
                <th width="200">
                    <input type="text" class="form-control" id="cantidad" placeholder="Cantidad">
                </th>
                <th width="200">
                    <input type="text" class="form-control" id="valor" placeholder="Precio">
                </th>
                <th width="50">
                    <button type="button" class="btn btn-ligth border" onclick="agregarItem();"><i class="bi bi-plus-circle"></i></button>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr id="filaMsjSinProductos">
                <td colspan="4">
                    <h5 class="text-center text-muted" >Agrega productos</h5>
                </td>
            </tr>
        </tbody>
    </table>
    <input type="hidden" name="productos" id="productos">
</form>
<script>
let productos = [];
let cantProductos = 1;
$("#frmAgregarVenta").validate({
    focusInvalid: true,
    errorPlacement: function (error, element) {
       $(element).addClass("is-invalid");
    },
    success: function (label) {
        $("#frmAgregarVenta").find("#"+$(label).attr("for")).removeClass('is-invalid'); 
    }
});
function agregarItem() {
    $("#alerta_supera").addClass("d-none");
    $("#alerta_sin_productos").addClass("d-none");
    $("#cantidad").removeClass('is-invalid');
    $("#valor").removeClass('is-invalid');

    const producto = $("#producto").val()
    ,cantidad = $("#cantidad").val()
    ,valor = $("#valor").val();
    let valido = true;

    if (!cantidad) {
        $("#cantidad").addClass('is-invalid');
        valido = false;
    }else if(parseInt(cantidad) > $("#producto").find("option:selected").data('stock')){
        $("#alerta_supera").removeClass("d-none");
        $("#alerta_supera").find("span").text($("#producto").find("option:selected").data('stock'))
        $("#cantidad").addClass('is-invalid');
        valido = false;
    }
    if (!valor) {
        $("#valor").addClass('is-invalid');
        valido = false;
    }
    if (!valido) {
        return;
    }
    $("#filaMsjSinProductos").addClass('d-none');

    $("table tbody").append(`
    <tr>
        <td>${$("#producto").find("option:selected").text()}</td>
        <td>${ cantidad }</td>
        <td>${ valor }</td>
        <td>
            <button type="buttom" class="btn btn-dark btn-sm" onclick="removerItem(this,${cantProductos});"><i class="bi bi-trash"></i></button>
        </td>
    </tr>
    `)
    //Agregando elemento al arreglo
    productos.push({
        "id":cantProductos++,
        "producto_id":producto,
        "cantidad":cantidad,
        "precio":valor,
    });
    //Actualizo stock
    const stock_actual = $("#producto").find("option:selected").data('stock') - cantidad;
    $("#producto").find("option:selected").data('stock',stock_actual);
    //Reseteo inputs
    $("#cantidad").val("");
    $("#valor").val("");
}
function removerItem(elem, id) {
    $(elem).closest("tr").remove();
    productos = productos.filter(function(value){
        return value.id !== id
    })
    if (productos.length == 0) {
        $("#filaMsjSinProductos").removeClass('d-none');
    }
}

function guardarVenta() {
    $("table select, table input").prop("disabled",true);
    if (productos.length == 0) {
        $("#alerta_sin_productos").removeClass("d-none");
    }else if ($("#frmAgregarVenta").valid()) {
        $("#productos").val(JSON.stringify(productos))
        $("#frmAgregarVenta").submit();
        
    }
    
    $("table select, table input").prop("disabled",false);
    
}

$("#producto").change(function (e) { 
    $("#valor").val($(this).find("option:selected").data('precio'));
});
$("#producto").trigger("change");
</script>
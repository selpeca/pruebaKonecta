<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom pt-4">
    <h3>Gestión de ventas</h3>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a class="btn btn-dark" href="?c=Ventas&a=Create"><i class="bi bi-plus-circle"></i> Vender</a>
    </div>
</div>
<div class="row">
    <?php if ($max_stock) { ?>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Producto con más stock</div>
                <div class="card-body">
                    <blockquote class="blockquote mb-0">
                        <p>
                            <a href="?c=Productos&a=View&id=<?= $max_stock[0]->id ?>"><?= $max_stock[0]->nombre ?></a> (<?= $max_stock[0]->stock ?> unids)
                        </p>
                    </blockquote>
                </div>
            </div>
        </div>
        <?php } ?>
    <?php if ($mas_vendido) { ?>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Producto más vendido</div>
                <div class="card-body">
                    <blockquote class="blockquote mb-0">
                        <p>
                            <a href="?c=Productos&a=View&id=<?= $mas_vendido[0]->id ?>"><?= $mas_vendido[0]->nombre ?></a> (<?= $mas_vendido[0]->cantidad ?> veces)
                        </p>
                    </blockquote>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<table class="table mt-3">
    <thead>
        <tr>
            <th width="50">id</th>
            <th>Fecha</th>
            <th>Productos</th>
            <th width="100">Valor</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if($ventas){
                foreach($ventas as $venta):
        ?>
            <tr>
                <th scope="row"><?= $venta->id ?></th>
                <td>
                    <?= $venta->fec_venta ?>
                </td>
                <td><?= $venta->productos_agg ?></td>
                <td>$ <?= $venta->precio ?></td>
            </tr>
        <?php 
                endforeach;
            }else{
        ?>
            <tr>
                <td colspan="4">
                    <h5 class="text-center text-muted">Sin ventas</h5>
                </td>
            </tr>
        <?php
            }
        ?>
    </tbody>
</table>
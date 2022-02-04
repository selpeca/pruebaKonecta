<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom pt-4">
    <h3>Gestión de productos</h3>
    <div class="btn-toolbar mb-2 mb-md-0">
        <buttom class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalApp" data-url="?c=Productos&a=Create" data-size="modal-lg"><i class="bi bi-plus-circle"></i> Nuevo</buttom>
    </div>
</div>
<table id="tblProductos" class="table nowrap">
    <thead>
        <tr>
            <th>Id</th>
            <th>Producto</th>
            <th>Categoria</th>
            <th>Stock</th>
            <th>Precio</th>
            <th class="text-center" width="100">...</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if($productos){
                foreach($productos as $p):
        ?>
            <tr>
                <th scope="row"><?= $p->id ?></th>
                <td>
                    <a href="?c=Productos&a=View&id=<?= $p->id ?>"><?= $p->nombre ?></a> (<?= $p->referencia ?>)
                </td>
                <td><?= $p->categoria ?></td>
                <td><?= $p->stock ?></td>
                <td>$ <?= $p->precio ?></td>
                <td class="text-center">
                    <buttom class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#modalApp" data-size="modal-lg" data-url="?c=Productos&a=Edit&id=<?= $p->id ?>"><i class="bi bi-pencil"></i></buttom>
                    <a class="btn btn-sm btn-light" href="?c=Productos&a=Delete&id=<?= $p->id ?>"><i class="bi bi-trash"></i></a>
                </td>
            </tr>
        <?php 
                endforeach;
            }else{
        ?>
            <tr>
                <td colspan="6">
                    <h5 class="text-center text-muted">Sin productos</h5>
                </td>
            </tr>
        <?php
            }
        ?>
    </tbody>
</table>
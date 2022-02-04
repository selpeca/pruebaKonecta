<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom pt-4">
    <h3>Ver: <b><?= $producto->nombre ?></b> <small class="text-muted">[<?= $producto->categoria ?>]</small></h3>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a class="btn btn-dark pr-2" href="?c=Productos"><i class="bi bi-arrow-left"></i> Atras</a>
            <button type="button" class="btn btn-dark dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item" href="javascript:;" data-bs-toggle="modal" data-bs-target="#modalApp" data-size="modal-lg" data-url="?c=Productos&a=Edit&id=<?= $producto->id ?>">Editar</a>
                </li>
                <li>
                    <a class="dropdown-item" href="?c=Productos&a=Delete&id=<?= $producto->id ?>">Eliminar</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<table class="table">
    <tbody>
        <tr>
            <th>Precio</th>
            <td>$ <?= $producto->precio ?></td>
        </tr>
        <tr>
            <th>Stock</th>
            <td><?= $producto->stock ?></td>
        </tr>
        <tr>
            <th>Referencia</th>
            <td><?= $producto->referencia ?></td>
        </tr>
        <tr>
            <th>Fecha de creación</th>
            <td><?= date('d/m/Y h:i:s A',strtotime($producto->fec_creacion)) ?></td>
        </tr>
    </tbody>
</table>
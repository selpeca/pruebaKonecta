<?php
require_once 'models/Venta.php';
require_once 'models/Producto.php';

class VentasController{
    
    private $venta;
    private $productos;
    private $jsondata;
    
    public function __CONSTRUCT(){
        $this->venta = new Venta();
        $this->productos = new Producto();
        $this->jsondata = array();
    }
    
    public function Index(){
        $ventas = $this->venta->get_ventas();
        $max_stock = $this->venta->get_max_stock();
        $mas_vendido = $this->venta->get_mas_vendido();
        require_once 'views/layouts/head.php';
        require_once 'views/ventas/index.php';
        require_once 'views/layouts/footer.php';
    }

    public function Create()
    {
        $productos = $this->productos->get_productos();
        require_once 'views/layouts/head.php';
        require_once 'views/ventas/create.php';
        require_once 'views/layouts/footer.php';
    }

    public function View()
    {
        $producto = $this->producto->get_productos(null,$_REQUEST["id"])[0];
        require_once 'views/layouts/head.php';
        require_once 'views/ventas/view.php';
        require_once 'views/layouts/footer.php';
    }

    public function Store()
    {
        $venta = new Venta();
        $venta->fec_venta = $_REQUEST['fec_venta'];

        $id_venta = $this->venta->Create($venta);

        $productos = json_decode($_REQUEST['productos'], true);

        $data = array();
        
        foreach ($productos as $producto) {
            $data[] = array(
                'venta_id'      => intval($id_venta),
                'producto_id'   => intval($producto['producto_id']),
                'cantidad'      => intval($producto['cantidad']),
                'precio'        => intval($producto['precio']),
            );
        }
        $result = $this->venta->CreateDetalle($data);

        if($result){
            $this->jsondata['result'] = true;
            $this->jsondata['class'] = 'success';
            $this->jsondata['message'] = 'Venta agregada.';
        }else{
            $this->jsondata['result'] = false;
            $this->jsondata['class'] = 'error';
            $this->jsondata['message'] = 'No se pudo publicar, intenta luego.';
        }
        
        header('Location: index.php?c=Ventas');

    }
}
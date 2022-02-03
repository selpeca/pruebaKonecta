<?php
require_once 'models/Producto.php';

class ProductosController{
    
    private $producto;
    private $jsondata;
    
    public function __CONSTRUCT(){
        $this->producto = new Producto();
        $this->jsondata = array();
    }
    
    public function Index(){
        $productos = $this->producto->get_productos(6);
        require_once 'views/layouts/head.php';
        require_once 'views/productos/index.php';
        require_once 'views/layouts/footer.php';
    }

    public function Create()
    {
        require_once 'views/productos/create.php';
    }

    public function View()
    {
        $producto = $this->producto->get_productos(null,$_REQUEST["id"])[0];
        require_once 'views/layouts/head.php';
        require_once 'views/productos/view.php';
        require_once 'views/layouts/footer.php';
    }

    public function Store()
    {
        $producto = new Producto();
        $producto->nombre = $_REQUEST['nombre'];
        $producto->referencia = $_REQUEST['referencia'];
        $producto->precio = $_REQUEST['precio'];
        $producto->stock = $_REQUEST['stock'];
        $producto->peso = $_REQUEST['peso'];
        $producto->categoria = $_REQUEST['categoria'];

        $id_producto = $this->producto->Create($producto);

        if($id_producto){
            $this->jsondata['result'] = true;
            $this->jsondata['class'] = 'success';
            $this->jsondata['message'] = 'Producto agregado exitosamente.';
        }else{
            $this->jsondata['result'] = false;
            $this->jsondata['class'] = 'error';
            $this->jsondata['message'] = 'No se pudo publicar, intenta luego.';
        }
        
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($this->jsondata);

    }

    public function Edit()
    {
        $producto = new Producto();
        $producto = $this->producto->get_productos(null,$_REQUEST["id"])[0];
        require_once 'views/productos/edit.php';
    }

    public function Update(){
        $producto = new Producto();
        $producto->nombre = $_REQUEST['nombre'];
        $producto->referencia = $_REQUEST['referencia'];
        $producto->precio = $_REQUEST['precio'];
        $producto->stock = $_REQUEST['stock'];
        $producto->peso = $_REQUEST['peso'];
        $producto->categoria = $_REQUEST['categoria'];
        $producto->id = $_REQUEST['id'];

        $id_producto = $this->producto->Update($producto);

        if($id_producto){
            $this->jsondata['result'] = true;
            $this->jsondata['class'] = 'success';
            $this->jsondata['message'] = 'Producto editado exitosamente.';
        }else{
            $this->jsondata['result'] = false;
            $this->jsondata['class'] = 'error';
            $this->jsondata['message'] = 'No se pudo editar, intenta luego.';
        }
        
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($this->jsondata);
    }

    public function Delete(){
        $producto = new Producto();
        $producto->id = $_REQUEST['id'];
        $this->producto->Delete($producto);
        header('Location: index.php?c=Productos');
    }
}
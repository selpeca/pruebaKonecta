<?php
class Producto{
    private $pdo;
    private $tabla = "productos";
    
	public $id;
	public $nombre;
	public $referencia;
	public $precio;
	public $peso;
	public $categoria;
	public $stock;
	public $fec_creacion;
	public function __CONSTRUCT()
	{
		try
		{
			$this->pdo = Database::StartUp();     
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}
	
	
    public function get_productos($limit = null,$producto_id = null){
		try{
			$sql = "SELECT
					`id`,
                        `nombre`,
                        `referencia`,
                        `precio`,
                        `peso`,
                        `categoria`,
                        `stock`,
                        `fec_creacion`
                    FROM `productos`";

			$sql.= " WHERE 1=1";
			
			if(!empty($producto_id)){
				$sql.= " AND productos.id = $producto_id";
			}

			$sql.=" ORDER BY productos.fec_creacion DESC";
			
			if(!empty($limit)){
				$sql.= " LIMIT $limit";
			}
 
			$stm = $this->pdo->prepare($sql);
			$stm->execute();
 
			return $stm->fetchAll(PDO::FETCH_OBJ);
		} catch(Exception $e){
			die($e->getMessage());
		}
	}
    
    public function Create(Producto $data)
	{
		try 
		{
		$this->pdo->beginTransaction();
		$sql = "INSERT INTO `productos` ( `nombre`, `referencia`, `precio`, `peso`, `categoria`, `stock`)  
		        VALUES (?, ?, ?, ?, ?, ?)";
 
 		$this->pdo->prepare($sql)
		     ->execute(
				array(
                    ucwords($data->nombre),
                    $data->referencia,
                    $data->precio,
                    $data->peso,
                    $data->categoria,
                    $data->stock
                )
			);
		
			$result = $this->pdo->lastInsertId();
			$this->pdo->commit();
			return $result;
		} catch (Exception $e) 
		{
			$this->pdo->rollback();
			die($e->getMessage());
		}
	}

	public function Update(Producto $data){
		try{
		$sql = "UPDATE productos SET
					`nombre` = ?, 
					`referencia` = ?, 
					`precio` = ?, 
					`peso` = ?, 
					`categoria` = ?, 
					`stock` = ?
				WHERE
					id=?";
 
 		return $this->pdo->prepare($sql)
		     ->execute(
				array(
                    ucwords($data->nombre),
                    $data->referencia,
                    $data->precio,
                    $data->peso,
                    $data->categoria,
                    $data->stock,
					$data->id
                )
			);
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}

	public function Delete(Producto $data){
		try{
		$sql = "DELETE FROM productos WHERE id = ?";
			return $this->pdo->prepare($sql)->execute(array($data->id));
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}
}
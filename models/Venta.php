<?php
class Venta{
    private $pdo;
    private $tabla = "ventas";
    
	public $id;
	public $fec_venta;
	public $productos;
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
	
	
    public function get_ventas($limit = null, $venta_id = null){
		try{
			$sql = "SELECT
						`ventas`.`id`,
						`ventas`.`fec_venta`,
						SUM(`productos_ventas`.`precio` * `productos_ventas`.`cantidad`) AS precio,
						GROUP_CONCAT(
							CONCAT(`productos`.`nombre`,'(',`productos_ventas`.`cantidad`,' x ', `productos_ventas`.`precio` ,')')
						) AS productos_agg
					FROM `ventas`
					INNER JOIN `productos_ventas` ON (`ventas`.`id` = `productos_ventas`.`venta_id`)
					INNER JOIN `productos` ON (`productos_ventas`.`producto_id` = `productos`.`id`)";

			$sql.= " WHERE 1=1";
			
			if(!empty($venta_id)){
				$sql.= " AND ventas.id = $producto_id";
			}
			
			if(!empty($limit)){
				$sql.= " LIMIT $limit";
			}

			$sql .=" GROUP BY 
				`ventas`.`id`,
				`ventas`.`fec_venta`";
 
			$stm = $this->pdo->prepare($sql);
			$stm->execute();
 
			return $stm->fetchAll(PDO::FETCH_OBJ);
		} catch(Exception $e){
			die($e->getMessage());
		}
	}

	public function get_max_stock()
	{
		try{
			$sql = "SELECT
					id,
					nombre,
					stock
				FROM
					productos
				ORDER BY
					stock DESC
				LIMIT 1";
			$stm = $this->pdo->prepare($sql);
			$stm->execute();
 
			return $stm->fetchAll(PDO::FETCH_OBJ)[0];
		} catch(Exception $e){
			die($e->getMessage());
		}
	}

	public function get_mas_vendido(){
		try{
			$sql = "SELECT
						productos.id,
						productos.nombre,
						SUM(productos_ventas.cantidad) AS cantidad
					FROM
						productos
						INNER JOIN productos_ventas ON (productos.id = productos_ventas.producto_id)
					GROUP BY
						productos.id,
						productos.nombre
					ORDER BY 3 DESC
					LIMIT 1";
			$stm = $this->pdo->prepare($sql);
			$stm->execute();
 
			return $stm->fetchAll(PDO::FETCH_OBJ)[0];
		} catch(Exception $e){
			die($e->getMessage());
		}
	}
    
    public function Create(Venta $data)
	{
		try 
		{
		$this->pdo->beginTransaction();
		$sql = "INSERT INTO `ventas` ( `fec_venta` ) VALUES (?)";
 
 		$this->pdo->prepare($sql)
		     ->execute(
				array(
                    $data->fec_venta
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

	function placeholders($text, $count=0, $separator=","){
		$result = array();
		if($count > 0){
			for($x=0; $x<$count; $x++){
				$result[] = $text;
			}
		}
	
		return implode($separator, $result);
	}

	public function CreateDetalle($data)
	{
		try 
		{
			$this->pdo->beginTransaction();
			$insert_values = array();
			foreach($data as $d){
				$question_marks[] = '('  . $this->placeholders('?', sizeof($d)) . ')';
				$insert_values = array_merge($insert_values, array_values($d));
			}
			$sql = "INSERT INTO `productos_ventas` ( `venta_id`, `producto_id`, `cantidad`, `precio`)  VALUES ".
				implode(',', $question_marks);
	
			$this->pdo->prepare($sql)->execute($insert_values);
			return $this->pdo->commit();
		}catch (Exception $e){
			$this->pdo->rollback();
			die($e->getMessage());
		}
	}
}
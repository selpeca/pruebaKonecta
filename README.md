# prueba Konecta
> Por: Sergio Pérez
## Puesta en marcha
1. Clonar repositorio o descargar ZIP
```sh
gh repo clone selpeca/pruebaKonecta
```
2. Crear base da datos
3. Ejecutar el archivo ```query.sql``` en su gestor de base de datos
4. Se debe configurar la base de datos creada en el archivo ```config.php``` con sus respectivos datos de acceso (Host, puerto, usuario, contraseña, nombre de la base de datos)
```
define('HOST', 'localhost');
define('PORT', 3306);
define('USER', 'root');
define('PASS', '');
define('DATABASE', 'prueba_konecta_db');
```
5. Ejecutar apache y buscar la ruta del proyecto
## Consulta 1.
¿Cuál es el producto que más stock tiene?
```
SELECT
    id,
	nombre,
	stock
FROM
    productos
ORDER BY
    stock DESC
LIMIT 1
```
## Consulta 2.
¿Cuál es el producto más vendido?
```
SELECT
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
LIMIT 1
```
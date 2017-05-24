<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/'.'config/DBconfig.php';

	/*
	* Clase encargada de la conexion a la base de datos.
	*
	* @author: David Fernández Flórez
	*/
	class DBPDO {
		
		/**
		* Metodo encargado de conectarse a la base de datos y ejecutar todas las consultas.
		*
		* @param $sql string Sentencia sql que se va a ejecutar en la base de datos.
		* @param $parametros array Parametros que se le van a pasar a la consulta preparada.
		* @return Devuelve el resultado de la consulta.
		*/
		public static function ejecutaConsulta($sql, $parametros){
			try	{
				//Creación de la conexión. Información de la BD + nombre de usuario + contraseóa
				$miBD = new PDO(DSN, USUARIO, PASSWORD); 
				
				//Definición de los atributos para que, si existe error, se lancen excepciones
				$miBD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
				//Preparación de la consulta preparada
				$preparedStatement = $miBD->prepare($sql);
				$preparedStatement->execute($parametros);
				
				//Captura de la excepción
			} catch (PDOException $pdoe) {
				$preparedStatement = null;
				
				//Cierre de la conexión
				unset($miBD); 
			}
			return $preparedStatement;
		}
	}
	
	
?>
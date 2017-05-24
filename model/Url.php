<?php
	require_once 'DBPDO.php';
	
	/**
	* Clase encargada de acortar url.
	*
	* @author: David Fernández Flórez
	*/
	class Url {
		/**
		* @AttributeType string
		*/
		private $shorturl;
		
		/**
		* @AttributeType string
		*/
		private $url;
		
		/**
		* @AttributeType string
		*/
		private $fechaCreacion;
			
		/**
		* @AttributeType int
		*/
		private $visitas; 
		
		/**
		* @AttributeType string
		*/
		private $propietario;
		
		/**
		* Constructor de la clase Url.
		*
		* @param string $shorturl Url acortada.
		* @param string $url Url introducida por el usuario.
		* @param string $fechaCreacion Fecha en la que se acorto la Url.
		* @param int $visitas Visitas de la Url.
		* @param string $propietario Usuario creador de la Url.
		*/
		public function __construct ($shorturl, $url, $fechaCreacion, $visitas, $propietario){
			$this -> shorturl = $shorturl; 
			$this -> url = $url;
			$this -> fechaCreacion = $fechaCreacion;
			$this -> visitas = $visitas;
			$this -> propietario = $propietario;
		}
		
		/**
		* Metodo encargado de insertar url en la base de datos.
		*
		* @param string $shorturl Url acortada.
		* @param string $url Url introducida por el usuario.
		* @param string $propietario Usuario creador de la Url.
		* @return llamada al metodo ejecutaConsulta de DBPDO.
		*/
		public static function insertarURL($shorturl, $url, $propietario){
			$objecturl = new Url($shorturl, $url, '2017-12-12' ,0, $propietario);
			$sql = 'insert into t_url (shorturl, url, visitas, propietario) values(?,?,?,?)';
			return DBPDO::ejecutaConsulta($sql,[$objecturl -> shorturl, $objecturl -> url, $objecturl -> visitas, $objecturl -> propietario]);
		} 
		
		/**
		* Metodo encargado de listar las url de un usuario.
		*
		* @param string $propietario Usuario creador de la Url.
		* @return Devuelve un array de objetos url.
		*/
		public static function listarURL($propietario){
			$arrayobjetos = [];
				$sql = 'select * from t_url where propietario = ?;';
				$array = DBPDO::ejecutaConsulta($sql, [$propietario]);
				if($array->rowCount()){
					$arrayurl = $array -> fetchAll(PDO::FETCH_ASSOC);
					for($i = 0; $i < count($arrayurl);$i++){
						$arrayobjetos[$i] = new Url ($arrayurl[$i]['shorturl'], $arrayurl[$i]['url'], $arrayurl[$i]['fechaCreacion'], $arrayurl[$i]['visitas'], $arrayurl[$i]['propietario']);
					}
				}
            return $arrayobjetos;
        }
		
		/**
		* Metodo encargado de buscar una url.
		*
		* @param string $url Url introducida por el usuario.
		* @return Devuelve un array de objetos url.
		*/
		public static function buscar($url){
			$arrayobjetos = [];
                $sql = 'select * from t_url where url = ?;';
                $resultSet = DBPDO::ejecutaConsulta($sql, [$url]);
                if($resultSet->rowCount()){
                    $arrayurl = $resultSet -> fetchAll(PDO::FETCH_ASSOC);
					for($i = 0; $i < count($arrayurl);$i++){
						$arrayobjetos[$i] = new Url ($arrayurl[$i]['shorturl'], $arrayurl[$i]['url'], $arrayurl[$i]['fechaCreacion'], $arrayurl[$i]['visitas'], $arrayurl[$i]['propietario']);
					}
                }
            return $arrayobjetos;
		}
		
		/**
		* Metodo encargado de insertar url en la base de datos.
		*
		* @param string $shorturl Url acortada.
		* @return Devuelve un array de objetos url.
		*/
		public static function buscarURL($shorturl){
			$arrayobjetos = [];
                $sql = 'select * from t_url where shorturl = ?;';
                $resultSet = DBPDO::ejecutaConsulta($sql, [$shorturl]);
                if($resultSet->rowCount()){
                    $arrayurl = $resultSet -> fetchAll(PDO::FETCH_ASSOC);
					for($i = 0; $i < count($arrayurl);$i++){
						$arrayobjetos[$i] = new Url ($arrayurl[$i]['shorturl'], $arrayurl[$i]['url'], $arrayurl[$i]['fechaCreacion'], $arrayurl[$i]['visitas'], $arrayurl[$i]['propietario']);
					}
                }       
            return $arrayobjetos;
		}
		
		/**
		* Metodo encargado de borrar una url de la base de datos.
		*
		* @param string $shorturl Url acortada.
		* @return llamada al metodo ejecutaConsulta de DBPDO.
		*/
		public static function borrarURL($shorturl){
			$sql = 'delete from t_url where shorturl = ?;';
			return DBPDO::ejecutaConsulta($sql,[$shorturl]);
		}
		
		/**
		* Metodo encargado de borrar url de la base de datos.
		*
		* @param string $propietario usuario que creo la url.
		* @return llamada al metodo ejecutaConsulta de DBPDO.
		*/
		public static function borrarUrlUsuario($propietario){
			$sql = 'delete from t_url where propietario = ?;';
			return DBPDO::ejecutaConsulta($sql,[$propietario]);
		}
		
		/**
		* Metodo encargado de sumar visitas a una url.
		*
		* @param string $shorturl Url acortada.
		* @return llamada al metodo ejecutaConsulta de DBPDO.
		*/
		public static function incrementarVisitas($shorturl){
			$sql = 'update t_url set visitas = visitas + 1 where shorturl = ?;';
			return DBPDO::ejecutaConsulta($sql, [$shorturl]);
		}	
		
		/**
		* Metodo encargado de acortar la url.
		*
		* @param string $url Url introducida por el usuario.
		* @return llamada al metodo insertarURL.
		*/
		public static function createHash($url){
			for ($i = 0; $i < 5; $i++){
				$hash2 = substr(hash('sha512', $url), rand(0,122), 1);
				$hash .= $hash2;
			}
			$busqueda = self::buscarURL($hash);
			if($busqueda != ''){
				return self::insertarURL($hash,$url, $_SERVER['REMOTE_ADDR']);
			}
		}
		
		/**
		* Metodo encargado de acortar la url con longitud variable.
		*
		* @param string $url Url introducida por el usuario.
		* @param int $longitud Longitud de la url-
		* @param string $propietario Usuario creador de la Url.
		* @return llamada al metodo insertarURL.
		*/
		public static function createHashLargo($url,$longitud,$propietario){
			for ($i = 0; $i < $longitud; $i++){
				$hash2 = substr(hash('sha512', $url), rand(0,107), 1);
				$hash .= $hash2;
			}
			$busqueda = self::buscarURL($hash);
			if($busqueda != ''){
				return self::insertarURL($hash,$url,$propietario);
			}
		}
		
		/**
		* Metodo encargado de acortar una url con un nombre personalizado.
		*
		* @param string $url Url introducida por el usuario.
		* @param string $customurl Url personalizada.
		* @param string $propietario Usuario creador de la Url.
		* @return llamada al metodo insertarURL.
		*/
		public static function createCustomUrl($url,$customurl, $propietario){
			$busqueda = self::buscarURL($customurl);
			if($busqueda != ''){
				return self::insertarURL($customurl,$url,$propietario);
			}
		}
		/**
		* Metodo encargado de contar el numero total de url.
		*
		* @param $propietario Usuario creador de la url.
		* @return Devuelve el total de registros de la tabla t_url.
		*/
		public static function totalRegistros($propietario){
			$sql = "select * from t_url where propietario = ?;";
			$total_registros = DBPDO::ejecutaConsulta($sql,[$propietario]);
			
			return $total_registros->rowCount();
		}
		
		/**
		* Metodo encargado de listar 4 registros por pagina empezando desde una posicion pasada por parametro.
		* 
		* @param $propietario Usuario creador de la url.
		* @param $inicio Posicion desde la que empieza a listar los resultados.
		* @return Devuelve un array de url.
		*/
		public static function listar($propietario, $inicio){
			$arrayobjetos = [];
				$sql = 'select * from t_url where propietario = ? ORDER BY  `t_url`.`fechaCreacion` DESC limit '.$inicio.', 4;';
				$array = DBPDO::ejecutaConsulta($sql, [$propietario]);
				if($array->rowCount()){
					$arrayurl = $array -> fetchAll(PDO::FETCH_ASSOC);
					for($i = 0; $i < count($arrayurl);$i++){
						$arrayobjetos[$i] = new Url ($arrayurl[$i]['shorturl'], $arrayurl[$i]['url'], $arrayurl[$i]['fechaCreacion'], $arrayurl[$i]['visitas'], $arrayurl[$i]['propietario']);
					}
				}
            return $arrayobjetos;
		}
		
		/**
		* Metodo get.
		*/
		public function __get($property){
			if (property_exists($this, $property)) {
				return $this->$property;
			}
		}

		/**
		* Metodo set.
		*/
		public function __set($property, $value) {
			if (property_exists($this, $property)) {
				$this->$property = $value;
			}
		}	
	}
?>
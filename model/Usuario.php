<?php
    require_once 'UsuarioPDO.php';
    /**
	* Clase usuario
	* @author: David Fernández Flórez
	*/
    class Usuario {
		/**
		* @AttributeType string
		*/
        private $user;
		
		/**
		* @AttributeType string
		*/
		private $email;
		
		/**
		* @AttributeType string
		*/
        private $password;
		
        /**
		* Constructor de la clase usuario.
		*
		* @param string $user Nombre del usuario.
		* @param string $password Contraseña del usuario.
		* @param string $email Email del usuario.
		*/
		public function __construct($user, $email, $password) {
            $this->user = $user;
			$this->email = $email;
			$this->password = $password;
        }
        
		/**
		* Metodo para validar que un usuario existe en la base de datos.
		*
		* @param string $user Nombre del usuario.
		* @param string $password Contraseña del usuario.
		* @return Devuelve null si no existe el usuario o el usuario en caso contrario.
		*/
        public static function validarUsuario($user, $password){
            $usuario = null;
            $userArray = UsuarioPDO::validarUsuario($user, $password);    
                if($userArray){
                    $usuario = new Usuario($user,$userArray['email'],$password);
                }
            return $usuario;
        }
		
		/**
		* Metodo para validar que un usuario existe en la base de datos.
		*
		* @param string $email Email del usuario.
		* @return Devuelve null si no existe el usuario o el usuario en caso contrario.
		*/
        public static function validarUsuarioEmail($email){
            $usuario = null;
            $userArray = UsuarioPDO::validarUsuarioEmail($email);    
                if($userArray){
                    $usuario = new Usuario($userArray['user'],$email, $userArray['password']);
                }
            return $usuario;
        }
		
		
		/**
		* Metodo para buscar un usuario existe en la base de datos.
		*
		* @param string $user Nombre del usuario.
		* @return Devuelve null si no existe el usuario o el usuario en caso contrario.
		*/
		public static function buscarUsuario($user){
            $usuario = null;
            $userArray = UsuarioPDO::buscarUsuario($user);    
                if($userArray){
                    $usuario = new Usuario($user, $userArray['email'], $userArray['password']);
                }
            return $usuario;
        }
		
		/**
		* Metodo encargado de agregar usuarios a la base de datos.
		*
		* @param string $user Nombre del usuario.
		* @param string $password Contraseña del usuario.
		* @param string $email Email del usuario.
		* @return llamada al metodo agregar usuario de UsuarioPDO para agregar al usuario a la base de datos.
		*/
		public static function agregarUsuario($user, $email, $password){
			$usuario = null;
				$userArray = UsuarioPDO::validarUsuario($user, $password);
				if(!$userArray){
					$usuario = new Usuario ($user, $email, $password);
				}
			return UsuarioPDO::agregarUsuario($usuario -> user, $usuario -> email, $usuario -> password);
		}
		
		/**
		* Metodo para borrar un usuario de la base de datos.
		*
		* @param string $user Nombre del usuario.
		* @return Llamada al metodo de borrarUsuario de UsuarioPDO para borrar el usuario de la base de datos.
		*/
		public static function borrarUsuario ($user){
			$usuario=null;
				$userArray = UsuarioPDO::buscarUsuario($user);
				if($userArray){
					$usuario = new Usuario($user,$userArray['password'],$userArray['email']);
				}
			return UsuarioPDO::borrarUsuario($usuario->user);
		}
		
		/**
		* Metodo encargado de cambiar la contraseña del usuario.
		*
		* @param $email Email del usuario.
		* @param $nuevapassword Contraseña nueva del usuario.
		* @return llamada al metodo recuperarPassword de UsuarioPDO.
		*/
		public static function recuperarPassword($email, $nuevapassword){
			$usuario = null;
				$userArray = UsuarioPDO::buscarUsuarioEmail($email);
				if($userArray){
					$hash = hash('sha256', $nuevapassword);
					$usuario = new Usuario($userArray['user'],$email, $hash);
				}
			return UsuarioPDO::recuperarPassword($usuario -> email, $usuario -> password);
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
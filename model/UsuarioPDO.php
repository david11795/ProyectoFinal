<?php
    require_once 'DBPDO.php';
    require_once 'UsuarioDB.php';
	
	/**
	* Clase UsuarioPDO
	* @author: David Fernández Flórez
	*/
    class UsuarioPDO implements UsuarioDB {
        
		/**
		* Metodo encargado de validar si un usuario existe en la base de datos.
		*
		* @param string $user Nombre del usuario.
		* @param string $password Contraseña del usuario.
		*/
        public static function validarUsuario($user, $password){
            $arrayUser = [];
            $sql = "SELECT * FROM usuario WHERE user=? AND password=?;"; 
               
            $resultSet=DBPDO::ejecutaConsulta($sql, [$user, $password]);
            if ($resultSet->rowCount()) { 
                $usuario = $resultSet->fetchObject();
                $arrayUser['email'] = $usuario->email;
            }
            return $arrayUser;
        }
		
		/**
		* Metodo encargado de validar si un usuario existe en la base de datos.
		*
		* @param string $email Email del usuario.
		* @param string $password Contraseña del usuario.
		*/
        public static function validarUsuarioEmail($email){
            $arrayUser = [];
            $sql = "SELECT * FROM usuario WHERE email=?;"; 
               
            $resultSet=DBPDO::ejecutaConsulta($sql, [$email]);
            if ($resultSet->rowCount()) { 
                $usuario = $resultSet->fetchObject();
                $arrayUser['user'] = $usuario->user;
            }
            return $arrayUser;
        }
		
		/**
		* Metodo encargado de buscar a un usuario en la base de datos.
		*
		* @param string $user Nombre del usuario.
		*/
        public static function buscarUsuario($user){
            $arrayUser = [];
            $sql = "SELECT * FROM usuario WHERE user=?;"; 
               
            $resultSet=DBPDO::ejecutaConsulta($sql, [$user]);
            if ($resultSet->rowCount()) { 
                $usuario = $resultSet->fetchObject();
                $arrayUser['email'] = $usuario->email;
				$arrayUser['password'] = $usuario->password;
            }
            return $arrayUser;
        }
		
		/**
		* Metodo encargado de buscar a un usuario en la base de datos.
		*
		* @param string $email Email del usuario.
		*/
		public static function buscarUsuarioEmail($email){
            $arrayUser = [];
            $sql = "SELECT * FROM usuario WHERE email=?;"; 
               
            $resultSet=DBPDO::ejecutaConsulta($sql, [$email]);
            if ($resultSet->rowCount()) { 
                $usuario = $resultSet->fetchObject();
                $arrayUser['user'] = $usuario->user;
				$arrayUser['password'] = $usuario->password;
            }
            return $arrayUser;
        }
		
		/**
		* Metodo encargado de agregar usuarios a la base de datos.
		*
		* @param string $user Nombre de usuario.
		* @param string $password Contraseña de usuario.
		* @param string $email Email del usuario.
		* @return llamada al metodo ejecutaConsulta de DBPDO para insertar el usuario.
		*/
		public static function agregarUsuario($user, $email, $password){
			$sql = "INSERT INTO usuario values (?,?,?)";
			return DBPDO::ejecutaConsulta($sql, [$user, $email, $password,]);
		}
		
		/**
		* Metodo encargado de cambiar contraseñas de usuarios de la base de datos.
		*
		* @param string $user Nombre de usuario.
		* @param string $password Contraseña de usuario.
		* @return llamada al metodo ejecutaConsulta de DBPDO para cambiar la contraseña.
		*/
		public static function recuperarPassword($email, $nuevapassword){
			$sql = 'UPDATE usuario set password = ? where email = ?;';
			return DBPDO::ejecutaConsulta($sql, [$nuevapassword, $email]);
		}
		
		/**
		* Metodo encargado de borrar usuarios de la base de datos.
		*
		* @param string $user Nombre del usuario.
		* @return llamada al metodo ejecutaConsulta de DBPDO para borrar el usuario.
		*/
		public static function borrarUsuario($user){
			$sql = "delete from usuario where user=?;";
			return DBPDO::ejecutaConsulta($sql,[$user]);
		}
    }
?>
<?php
	class usuario
	{
	private $idUser;
	private $idCliente;
	private $userName;
	private $userFullName;
	private $mailUsuario;
	private $password;
	private $level;
	private $company;
	private $permisos;

		function __construct()
		{
			if(func_num_args()==9)
			{
				$this->idUser = func_get_arg(0);
				$this->idCliente = func_get_arg(1);
				$this->userName = func_get_arg(2);
				$this->userFullName = func_get_arg(3);
				$this->mailUsuario = func_get_arg(4);
				$this->password = func_get_arg(5);
				$this->level = func_get_arg(6);
				$this->company = func_get_arg(7);
				$this->permisos = func_get_arg(8);
			}else{
				if(func_num_args()==8)
				{
					$this->idUser = func_get_arg(0);
					$this->idCliente = func_get_arg(1);
					$this->userName = func_get_arg(2);
					$this->userFullName = func_get_arg(3);
					$this->mailUsuario = func_get_arg(4);
					$this->password = func_get_arg(5);
					$this->level = func_get_arg(6);
					$this->company = func_get_arg(7);
				}
				else 
				{
					if(func_num_args()==7)
					{
						$this->idUser = func_get_arg(0);
						$this->idCliente = func_get_arg(1);
						$this->userName = func_get_arg(2);
						$this->userFullName = func_get_arg(3);
						$this->mailUsuario = func_get_arg(4);
						$this->password = func_get_arg(5);
						$this->level = func_get_arg(6);
					}
					else
					{
						if(func_num_args()==6){
							$this->idUser = func_get_arg(0);
							$this->idCliente = func_get_arg(1);
							$this->userName = func_get_arg(2);
							$this->userFullName = func_get_arg(3);
							$this->mailUsuario = func_get_arg(4);
							$this->level = func_get_arg(5);
						}
						else{
							$this->idUser=null;
							$this->userName=null;
							$this->userFullName=null;
							$this->mailUsuario=null;
							$this->password=null;
							$this->level=null;
						}
					}
				}
			}			
		}
		//Funciones SET
		
		function setidUsuario($value)
		{
			$this->idUser = $value;
		}
		function setuserName($value)
		{
			$this->userName = $value;
		}
		function setuserFullName($value)
		{
			$this->userFullName = $value;
		}
		function setmailUsuario($value)
		{
			$this->mailUsuario = $value;
		}
		function setpassword($value)
		{
			$this->password = $value;
		}
		function setPrivilegio($value)
		{
			$this->level = $value;
		}
		function setcompany($value)
		{
			$this->company = $value;
		}
		function setPermisos($value)
		{
			$this->permisos = $value;
		}
		// Funciones GET. 
						
		public function getIdUsuario()
		{
			return $this->idUser;
		}
		public function getuserName()
		{
			return $this->userName;
		}
		public function getuserFullName()
		{
			return $this->userFullName;
		}
		public function getmailUsuario()
		{
			return $this->mailUsuario;
		}
		public function getPassword()
		{
			return $this->password;
		}
		public function getPrivilegio()
		{
			return $this->level;
		}
		public function getcompany()
		{
			return $this->company;
		}
		public function getPermisos()
		{
			return $this->permisos;
		}
		public function getidCliente()
		{
			return $this->idCliente;
		}
	}
?>
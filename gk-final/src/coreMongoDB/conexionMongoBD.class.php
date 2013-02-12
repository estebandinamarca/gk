<?php
class conexionMDB
{
	protected $direccion;
	protected $usuario;
	protected $puerto;
	protected $password;
	protected $nameBD;
	protected $database;
	protected $conexion;
	protected $is_conected = false;
	
	static $_instance;
	
	private function __clone(){
		trigger_error('Objeto conexionMySQLi no se puede clonar.', E_USER_ERROR);
	}
	
	public static function getInstance(){
		if (!(self::$_instance instanceof self)){
			self::$_instance=new self();
		}
		return self::$_instance;
	}
	
	private function __construct(){
		$this->setConexion();
		$this->conectar();
	}
	
	//genera la la conexion con los parametros de configuracion
	private function setConexion(){
		$conf = Config::getInstance();
		$this->direccion=$conf->getDireccion();
		$this->nameBD=$conf->getBD();
		$this->puerto=$conf->getpuerto();
		$this->usuario=$conf->getUsuarioBD();
		$this->password=$conf->getPasswd();
		//print_r($conf); die();
		
	}
	
	//metodo para conectar
	public function conectar()
	{
		$connectionString = sprintf('mongodb://%s:%d',$this->direccion,$this->puerto);
		try
		{
			$this->conexion = new Mongo($connectionString);
			$this->database = $this->conexion->selectDB($this->nameBD);
			$this->is_conected = true;
		} catch(MongoConnectionException $e) {
			//handle connection error
			die($e->getMessage());
		}
	}
	
	//esta conectado?
	public function isConnected(){
		return $this->is_conected;
	}
	
	//desconecta la conexion
	public function desconectar(){
		$this->conexion->close();
		unset($this->conexion);
		$this->is_conected = false;
	}
	
	//collections donde se buscara
	public function getCollection($name)
	{
		return $this->database->selectCollection($name);
	}
	public function ejecutarSentencia($collection,$param)
	{
		if($this->is_conected)
		{
			if($param!=null)
			{
				
			}
		}
	}
}

?>
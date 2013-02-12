<?php
/*
 * http://php.net/manual/es/class.mongodb.php
 * */
require_once 'src/coreMongoDB/conexionMongoBD.class.php';
require_once 'src/coreMongoDB/confMDB.class.php';
/*
$noSQl = conexionMDB::getInstance();
$collection = $noSQl->getCollection("reserva");
$cursor = $collection->find();
echo "<pre>";
foreach ($cursor as $dat)
{
	print_r($dat);
}
*/
try{
	$connectionString = sprintf('mongodb://%s:%d',"127.0.0.1", "27017");
	$mongo	= new Mongo($connectionString); //create a connection to MongoDB
	$database = $mongo->selectDB("reservagk"); //List all databases
	$collection = $database->selectCollection("reserva"); //selectCollection('reserva'); //collections de las base de datos
	$cursor = $database->listCollections();//find();
	//$databases = $mongo->listDBs();
	//$cursor = $collection->find(array('genre' => 'sci-fi'));
	
	echo '<pre>';
	//print_r($cursor);die();
	
	echo '<pre>';
	if(true)//($cursor->count()>0)
	{
		foreach($cursor as $data)
		{
			print_r($data);
		}
	}
	
	
	$mongo->close();
} catch(MongoConnectionException $e) {
	//handle connection error
	die($e->getMessage());
}

?>
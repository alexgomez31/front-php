<?php
	
	include 'conexion.php';
	
	$pdo = new Conexion();
	
	//Listar registros y consultar registro
	if($_SERVER['REQUEST_METHOD'] == 'GET'){
		if(isset($_GET['id']))
		{
			$sql = $pdo->prepare("SELECT * FROM contactos WHERE id=:id");
			$sql->bindValue(':id', $_GET['id']);
			$sql->execute();
			$sql->setFetchMode(PDO::FETCH_ASSOC);
			header("HTTP/1.1 200 hay datos");
			echo json_encode($sql->fetchAll());
			exit;				
			
			} else {
			
			$sql = $pdo->prepare("SELECT * FROM contactos");
			$sql->execute();
			$sql->setFetchMode(PDO::FETCH_ASSOC);
			header("HTTP/1.1 200 hay datos");
			echo json_encode($sql->fetchAll());
			exit;		
		}
	}
	
	//Insertar registro
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$sql = "INSERT INTO contactos (nombre, telefono, email) VALUES(:nombre, :telefono, :email)";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':nombre', $_POST['nombre']);
		$stmt->bindValue(':telefono', $_POST['telefono']);
		$stmt->bindValue(':email', $_POST['email']);
		$stmt->execute();
		$idPost = $pdo->lastInsertId(); 
		if($idPost)
		{
			header("HTTP/1.1 200 Ok");
			echo json_encode($idPost);
			exit;
		}
	}
	



	// Actualizar registro
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
	
	$requestData = json_decode(file_get_contents('php://input'), true);
	
	
	if ($requestData) {
	  $sql = "UPDATE contactos SET nombre=:nombre, telefono=:telefono, email=:email WHERE id=:id";
	  $stmt = $pdo->prepare($sql);
	  $stmt->bindValue(':nombre', $requestData['nombre']);
	  $stmt->bindValue(':telefono', $requestData['telefono']);
	  $stmt->bindValue(':email', $requestData['email']);
	  $stmt->bindValue(':id', $_GET['id']);
	  $stmt->execute();
	  header("HTTP/1.1 200 Ok");
	  exit;
	}
	
	header("HTTP/1.1 400 Bad Request");
	exit;
  }
  
	
	//Eliminar registro
	if($_SERVER['REQUEST_METHOD'] == 'DELETE')
	{
		$sql = "DELETE FROM contactos WHERE id=:id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':id', $_GET['id']);
		$stmt->execute();
		header("HTTP/1.1 200 Ok");
		exit;
	}
	
	
	header("HTTP/1.1 400 Bad Request");
?>
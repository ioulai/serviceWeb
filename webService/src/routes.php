<?php
// Routes

$app->get('/[{name}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});


	$app->get('/hello/{name}/{prenom}', function ($request, $response, $args) {
		$name = $request->getAttribute('name');
		$prenom=$request->getAttribute('prenom');
		$response->getBody()->write("hello, $name,$prenom");
		return $response;
	});
	
		
		
	

	$app->get('/personnex/', function ($request, $response, $args) {	
		$req = $this->db->prepare("SELECT nom, prenom FROM personne p join personne_login pl on p.id = pl.id where login = :login and mp = :mp");		
		//$req->bindParam("login", $args['login']);			
		$req->execute();
		$user = $req->fetchAll();		
		return $this->response->withJson($user);	
	});
	
		//recuperer nom prenom en fonction du login
		$app->get('/personne/[{login}]', function ($request, $response, $args) {
			$sth = $this->db->prepare("SELECT nom, prenom FROM personne p join personne_login pl on p.id = pl.id where login = :login ");
			$sth->bindParam("login", $args['login']);
			$sth->execute();
			$todos = $sth->fetchObject();
			return $this->response->withJson($todos);
			});
		
		
	/*	$app->get('/chambre', function ($request, $response, $args) {
			$sth = $this->db->prepare("SELECT * FROM chambre_forte");
			$sth->execute();
			$todos = $sth->fetchAll();
			return $this->response->withJson($todos);
		});
		
		
	
		
		$app->get('/personne/[{login}]&[{mp}]', function ($request, $response, $args) {
			$sth = $this->db->prepare("SELECT nom, prenom FROM personne p join personne_login pl on p.id = pl.id where login = :login and mp = :mp");
			$sth->bindParam("login", $args['login']&&"mp", $args['mp']);
			//$sth->bindParam("login", $args['login']);
			//$sth->bindParam("mp", $args['mp']);
			$sth->execute();
			$todos = $sth->fetchAll();
			return $this->response->withJson($todos);
		});
			*/ 

		
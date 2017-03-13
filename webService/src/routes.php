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

	
	    //recuperer nom prenom en fonction du login et mp
		$app->get('/getPersInfo/{login}/{mp}', function ($request, $response, $args) {
			$sth = $this->db->prepare("SELECT * FROM personne p join personne_login pl on p.id = pl.id join patient pa on p.id = pa.id where login = :login and mp = :mp");
			$sth->bindParam("login", $args['login']);
			$sth->bindParam("mp", $args['mp']);
			$sth->execute();
			$todos = $sth->fetchObject();
			return $this->response->withJson($todos);
			});
		
		//connexion à l'application	
			$app->get('/getConnect/{login}/{mp}', function ($request, $response, $args) {
			$sth = $this->db->prepare("SELECT * FROM personne_login where login = :login and mp = :mp");			
			$sth->bindParam("login", $args['login']);
			$sth->bindParam("mp", $args['mp']);
			$sth->execute();
			$todos = $sth->fetchObject();			
			return $this->response->withJson($todos);
		});	
		
			
		
	
		
	
		
		
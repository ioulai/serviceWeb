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
/**************************************************************************************************************************************************/	
/************************************************************** REQUETE GET ***********************************************************************/
/**************************************************************************************************************************************************/	
	
	    //connexion Ã  l'application infirmiere
		$app->get('/getCoInf/{login}/{mp}', function ($request, $response, $args) {
			$sth = $this->db->prepare("select P.nom, p.prenom from personne_login pl join personne p on pl.id = p.id join infirmiere i on i.id = p.id where login= :login  and mp = :mp");
			$sth->bindParam("login", $args['login']);
			$sth->bindParam("mp", $args['mp']);
			$sth->execute();
			$todos = $sth->fetchObject();			
			
		return $this->response->withJson($todos)
		->withHeader('Access-Control-Allow-Origin', '*')
		->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
		->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
			});
		
		//connexion Ã  l'application patient
			$app->get('/getCoPa/{login}/{mp}', function ($request, $response, $args) {
			$sth = $this->db->prepare("select * from personne_login pl join personne p on pl.id = p.id join patient pa on pa.id=p.id where login = :login and mp = MD5(:mp)");			
			$sth->bindParam("login", $args['login']);
			$sth->bindParam("mp", $args['mp']);
			$sth->execute();	
			$todos = $sth->fetchObject();			
			return $this->response->withJson($todos)
			->withHeader('Access-Control-Allow-Origin', '*')
			->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
			->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
		});	
			
		//	Visualisation du planning passé ou à venir de l'infirmiere	
			/*	$app->get('/getPlanning/{login}/{mp}', function ($request, $response, $args) {
					$sth = $this->db->prepare("SELECT login, mp FROM personne_login where login = :login and mp = :mp");
					$sth->bindParam("login", $args['login']);
					$sth->bindParam("mp", $args['mp']);
					$sth->execute();
					$todos = $sth->fetchObject();
					return $this->response->withJson($todos);
				});*/
/**************************************************************FIN REQUETE GET**********************************************************************/			

			
	
			
/**************************************************************************************************************************************************/			
/************************************************************** REQUETE PUT ***********************************************************************/		
/**************************************************************************************************************************************************/
		//Modification patient
		$app->put('/setInfirmiere/{id}', function ($request, $response, $args){
			$sth = $this->db->prepare("UPDATE infirmiere SET informations_medicales = :informations_medicales, personne_de_confiance = :personne_de_confiance, infirmiere_souhait = :infirmiere_souhait  where p.id = :id");
			$sth->bindParam("id", $args['id']);
			$sth->bindParam("informations_medicales", $args['informations_medicales']);
			$sth->bindParam("personne_de_confiance", $args['personne_de_confiance']);
			$sth->bindParam("infirmiere_souhait", $args['infirmiere_souhait']);
			$sth->execute();
			$todos = $sth->fetchObject();
			return $this->response->withJson($todos);
			
		});
		
		//modification mot de passe patient
		$app->put('/setMpPatient/{login}', function ($request, $response, $args){
			$sth = $this->db->prepare("UPDATE personne_login set mp = :mp where login = :login ");
			$sth->bindParam("login", $args['login']);
			$sth->bindParam("mp", $args['mp']);
			$sth->execute();
			$todos = $sth->fetchObject();
			return $this->response->withJson($todos);
		});

/************************************************************** FIN REQUETE PUT ********************************************************************/			


/**************************************************************************************************************************************************/
/************************************************************** REQUETE POST **********************************************************************/
/**************************************************************************************************************************************************/		
	
		
		
		
/*********************************************************** FIN REQUETE POST **********************************************************************/
		
	
		
		
		
/**************************************************************************************************************************************************/		
/************************************************************** REQUETE DELETE ********************************************************************/
/**************************************************************************************************************************************************/			

		
		
			
/************************************************************* FIN REQUETE DELETE ******************************************************************/
	
		
	
		
		

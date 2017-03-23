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
/**************************************************************FIN REQUETE GET**********************************************************************/			

			
	
			
/**************************************************************************************************************************************************/			
/************************************************************** REQUETE PUT ***********************************************************************/		
/**************************************************************************************************************************************************/
	/*	//Modification patient
		$app->put('/setPatient/{id}', function ($request, $response, $args){
			$sth = $this->db->prepare("UPDATE patient SET informations_medicales = :informations_medicales, personne_de_confiance = :personne_de_confiance, infirmiere_souhait = :infirmiere_souhait  where p.id = :id");
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
		});*/

/************************************************************** FIN REQUETE PUT ********************************************************************/			


/**************************************************************************************************************************************************/
/************************************************************** REQUETE POST **********************************************************************/
/**************************************************************************************************************************************************/		
	
		
		
		
/*********************************************************** FIN REQUETE POST **********************************************************************/
		
	
		
		
		
/**************************************************************************************************************************************************/		
/************************************************************** REQUETE DELETE ********************************************************************/
/**************************************************************************************************************************************************/			

		
		
			
/************************************************************* FIN REQUETE DELETE ******************************************************************/
	
		
	
		
		
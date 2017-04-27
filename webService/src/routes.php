<?php
// Routes
function utf8($n) {
	return (utf8_encode ( $n ));
}

$app->get ( '/[{name}]', function ($request, $response, $args) {
	// Sample log message
	$this->logger->info ( "Slim-Skeleton '/' route" );
	
	// Render index view
	return $this->renderer->render ( $response, 'index.phtml', $args );
} );

$app->get ( '/hello/{name}/{prenom}', function ($request, $response, $args) {
	$name = $request->getAttribute ( 'name' );
	$prenom = $request->getAttribute ( 'prenom' );
	$response->getBody ()->write ( "hello, $name,$prenom" );
	return $response;
} );
/**
 * ***********************************************************************************************************************************************
 */
/**
 * ************************************************************ REQUETE GET **********************************************************************
 */
/**
 * ***********************************************************************************************************************************************
 */

// connexion Ã  l'application infirmiere
$app->get ( '/getCoInf/{login}/{mp}', function ($request, $response, $args) {
	$sth = $this->db->prepare ( "select P.nom, p.prenom from personne_login pl 
										join personne p on pl.id = p.id 
										join infirmiere i on i.id = p.id 
										where login= :login  and mp = MD5(:mp)" );
	$sth->bindParam ( "login", $args ['login'] );
	$sth->bindParam ( "mp", $args ['mp'] );
	$sth->execute ();
	$todos = $sth->fetchObject ();
	return $this->response->withJson ( $todos )->withHeader ( 'Access-Control-Allow-Origin', '*' )->withHeader ( 'Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization' )->withHeader ( 'Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS' );
} );

// connexion Ã  l'application patient
$app->get ( '/getCoPa/{login}/{mp}', function ($request, $response, $args) {
	$sth = $this->db->prepare ( "select P.nom, p.prenom from personne_login pl
										join personne p on pl.id = p.id
										join patient pa on pa.id=p.id
										where login = :login and mp = MD5(:mp)" );
	$sth->bindParam ( "login", $args ['login'] );
	$sth->bindParam ( "mp", $args ['mp'] );
	$sth->execute ();
	$todos = $sth->fetchObject ();
	return $this->response->withJson ( $todos )->withHeader ( 'Access-Control-Allow-Origin', '*' )->withHeader ( 'Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization' )->withHeader ( 'Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS' );
} );

// Retourne une personne dont l'id est passé en parametre
$app->get ( '/getPers/{id}', function ($request, $response, $args) {
	$sth = $this->db->prepare ( "SELECT * FROM personne WHERE id = :id " );
	$sth->bindParam ( "id", $args ['id'] );
	$sth->execute ();
	$response = $sth->fetchObject ();
	
	return $this->response->withJson ( $response )->withHeader ( 'Access-Control-Allow-Origin', '*' )->withHeader ( 'Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization' )->withHeader ( 'Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS' );
} );

// retourne toutes les infos de la personne dont le nom et le prenom sont passés en paramètre
$app->get ( '/getPersInfo/{nom}/{prenom}', function ($request, $response, $args) {
	$sth = $this->db->prepare ( "SELECT * FROM personne WHERE nom = :nom and prenom = :prenom" );
	$sth->bindParam ( "nom", $args ['nom'] );
	$sth->bindParam ( "prenom", $args ['prenom'] );
	$sth->execute ();
	$response = $sth->fetchObject ();
	
	return $this->response->withJson ( $response )->withHeader ( 'Access-Control-Allow-Origin', '*' )->withHeader ( 'Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization' )->withHeader ( 'Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS' );
} );

// retourne l'infirmière dont l'id est passé en paramètre
$app->get ( '/getInf/{id}', function ($request, $response, $args) {
	$sth = $this->db->prepare ( "SELECT id_badge, id_infirmiere, fichier_photo FROM infirmiere i 
								JOIN infirmiere_badge ib ON i.id = ib.id_infirmiere 
								WHERE id_badge = :id " );
	$sth->bindParam ( "id", $args ['id'] );
	$sth->execute ();
	$response = $sth->fetchObject ();
	
	return $this->response->withJson ( $response )->withHeader ( 'Access-Control-Allow-Origin', '*' )->withHeader ( 'Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization' )->withHeader ( 'Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS' );
} );
// retourne le type de soin dont l'id est passé en paramètre
$app->get ( '/getTypeSoin/{id}', function ($request, $response, $args) {
	$sth = $this->db->prepare ( "SELECT * FROM type_soins WHERE id_type_soins = :id " );
	$sth->bindParam ( "id", $args ['id'] );
	$sth->execute ();
	$json = array ();
	while ( $row = $sth->fetch ( PDO::FETCH_ASSOC ) ) {
		$json [] = array_map ( 'utf8', $row );
	}
	$response = $json;
	
	return $this->response->withJson ( json_encode ( $response ) )->withHeader ( 'Access-Control-Allow-Origin', '*' )->withHeader ( 'Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization' )->withHeader ( 'Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS' );
} );

// recupére toutes les visites, le paramètre ne sert à rien
$app->get ( '/getVisite/{infirmiere}', function ($request, $response, $args) {
	$sth = $this->db->prepare ( "SELECT nom AS title, DATE(date_prevue) AS start FROM visite 
								JOIN PATIENT ON VISITE.patient = PATIENT.id 
								JOIN PERSONNE ON PATIENT.id = PERSONNE.id 
								where infirmiere = :infirmiere" );
	$sth->bindParam ( "infirmiere", $args ['infirmiere'] );
	$sth->execute ();
	$json = array ();
	while ( $row = $sth->fetch ( PDO::FETCH_ASSOC ) ) {
		$json [] = array_map ( 'utf8', $row );
	}
	$response = $json;
	
	return $this->response->withJson ( $response )->withHeader ( 'Access-Control-Allow-Origin', '*' )->withHeader ( 'Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization' )->withHeader ( 'Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS' );
} );

// Recupére les visites pour la date passée en paramètres
$app->get ( '/getVisiteSemaine/{date}', function ($request, $response, $args) {
	$sth = $this->db->prepare ( "SELECT * FROM visite WHERE date_prevue = :date" );
	$sth->bindParam ( "date", $args ['date'] );
	$sth->execute ();
	$json = array ();
	while ( $row = $sth->fetch ( PDO::FETCH_ASSOC ) ) {
		$json [] = array_map ( 'utf8', $row );
	}
	$response = $json;
	
	return $this->response->withJson ( json_encode ( $response ) )->withHeader ( 'Access-Control-Allow-Origin', '*' )->withHeader ( 'Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization' )->withHeader ( 'Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS' );
} );

// retourne les specialites de l'infirmiere dont l'id est passé en paramètre
$app->get ( '/getSpeInf/{id}', function ($request, $response, $args) {
	$sth = $this->db->prepare ( "SELECT * FROM specialisation s JOIN infirmiere i ON s.id_infirmiere = i.id
																  JOIN type_soins ts ON s.id_type_soins = ts.id_type_soins
																  JOIN categ_soins cs ON s.id_categ_soins = cs.id
																  WHERE s.id_infirmiere = :id" );
	$sth->bindParam ( "id", $args ['id'] );
	$sth->execute ();
	$json = array ();
	while ( $row = $sth->fetch ( PDO::FETCH_ASSOC ) ) {
		$json [] = array_map ( 'utf8', $row );
	}
	$response = $json;
	
	return $this->response->withJson ( json_encode ( $response ) )->withHeader ( 'Access-Control-Allow-Origin', '*' )->withHeader ( 'Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization' )->withHeader ( 'Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS' );
} );
// Test si le mail est existant
$app->get ( '/mail/{login}', function ($request, $response, $args) {
	$sth = $this->db->prepare ( "select * from personne where mail =  :mail" );
	$sth->bindParam ( "login", $args ['login'] );
	$sth->execute ();
	$response = $sth->fetchObject ();
	return $this->response->withJson ( $response )->withHeader ( 'Access-Control-Allow-Origin', '*' )->withHeader ( 'Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization' )->withHeader ( 'Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS' );
} );

/**
 * ************************************************************FIN REQUETE GET*********************************************************************
 */

/**
 * ***********************************************************************************************************************************************
 */
/**
 * ************************************************************ REQUETE PUT **********************************************************************
 */
/**
 * ***********************************************************************************************************************************************
 */
// Modification patient
$app->put ( '/setPa/{id}', function ($request, $response, $args) {
	$sth = $this->db->prepare ( "UPDATE patient
			SET informations_medicales = :informations_medicales,
			personne_de_confiance = :personne_de_confiance
			, infirmiere_souhait = :infirmiere_souhait 
			where p.id = :id" );
	$sth->bindParam ( "id", $args ['id'] );
	$sth->bindParam ( "informations_medicales", $args ['informations_medicales'] );
	$sth->bindParam ( "personne_de_confiance", $args ['personne_de_confiance'] );
	$sth->bindParam ( "infirmiere_souhait", $args ['infirmiere_souhait'] );
	$sth->execute ();
	$todos = $sth->fetchObject ();
	return $this->response->withJson ( $todos );
} );
// modification mot de passe
$app->put ( '/setMP/{login}', function ($request, $response, $args) {
	$data = array (
			"status" => "false" 
	);
	$data = $request->getParsedBody ();
	$sth = $this->db->prepare ( "UPDATE personne_login set mp = MD5(:mp) where login = :login " );
	$ticket_data = [ ];
	$ticket_data ['mp'] = filter_var ( $data ['mp'], FILTER_SANITIZE_STRING );
	$ticket_data ['login'] = filter_var ( $data ['login'], FILTER_SANITIZE_STRING );
	$sth->bindParam ( "login", $ticket_data ['login'] );
	$sth->bindParam ( "mp", $ticket_data ['mp'] );
	$sth->execute ();
	if ($sth) {
		$data = array (
				"status" => "true" 
		);
	}
	return $this->response->withJson ( $data )->withHeader ( 'Access-Control-Allow-Origin', '*' )->withHeader ( 'Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization' )->withHeader ( 'Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS' );
} );

/**
 * ************************************************************ FIN REQUETE PUT *******************************************************************
 */
/**
 * ***********************************************************************************************************************************************
 */

/**
 * ************************************************************ REQUETE POST *********************************************************************
 */
/**
 * ***********************************************************************************************************************************************
 */

// modification du nom, prenom d'une personne
$app->post ( '/setPers/{id}', function ($request, $response, $args) {
	$data = array (
			"status" => "false" 
	);
	$data = $request->getParsedBody ();
	$sth = $this->db->prepare ( "UPDATE personne SET prenom = :prenom, nom = :nom WHERE id = :id" );
	$ticket_data = [ ];
	$ticket_data ['prenom'] = filter_var ( $data ['prenom'], FILTER_SANITIZE_STRING );
	$ticket_data ['nom'] = filter_var ( $data ['nom'], FILTER_SANITIZE_STRING );
	$sth->bindParam ( "id", $args ['id'] );
	$sth->bindParam ( "prenom", $ticket_data ['prenom'] );
	$sth->bindParam ( "nom", $ticket_data ['nom'] );
	$sth->execute ();
	
	if ($sth) {
		if ($sth->rowCount () == 1) {
			$data = array (
					"status" => "true" 
			);
		}
	}
	return $this->response->withStatus ( 200 )->withHeader ( 'Access-Control-Allow-Origin', '*' )->withHeader ( 'Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization' )->withHeader ( 'Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS' )->write ( json_encode ( $data ) );
} );

/**
 * ********************************************************* FIN REQUETE POST *********************************************************************
 */

/**
 * ***********************************************************************************************************************************************
 */
/**
 * ************************************************************ REQUETE DELETE *******************************************************************
 */
/**
 * ***********************************************************************************************************************************************
 */
// suppression connaissant l'id de la personne
$app->delete ( '/delPa/{id}', function ($request, $response, $args) {
	$data = array (
			"status" => "false" 
	);
	$sth = $this->db->prepare ( "DELETE FROM patient WHERE id = :id " );
	$sth->bindParam ( "id", $args ['id'] );
	$sth->execute ();
	if ($sth) {
		if ($sth->rowCount () == 1) {
			$data = array (
					"status" => "true" 
			);
		}
	}
	
	$response = $sth->fetchAll ();
	
	return $this->response->withStatus ( 200 )->withHeader ( 'Access-Control-Allow-Origin', '*' )->withHeader ( 'Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization' )->withHeader ( 'Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS' )->write ( json_encode ( $data ) );
} );
		


		
	/************************************************************* FIN REQUETE DELETE ******************************************************************/
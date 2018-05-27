<?php
use App\Controllers\_Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

// REDIRECCIÓN a la APP
$app->get('/', function(Request $request, Response $response, $args) {
	return $response->withStatus(302)->withHeader('Location','/app');
});

// APP (Frontend)
$app->group('/app', function() {
	$this->get('', function(Request $request, Response $response) {
		return $this->view->render($response, 'app.twig', [
			'desarrollador' => 'Alberto Jiménez Gibaja | alberto.jg@hotmail.es'
		]);
	});
	$this->group('/alergenos', function() {
		$this->get('', function(Request $request, Response $response) {
			return $this->view->render($response, 'alergenos.twig');
		});
	});
	$this->group('/ingredientes', function() {
		$this->get('', function(Request $request, Response $response) {
			return $this->view->render($response, 'ingredientes.twig');
		});
	});
	$this->group('/platos', function() {
		$this->get('', function(Request $request, Response $response) {
			return $this->view->render($response, 'platos.twig');
		});
	});
});

// API
$app->group('/api', function() {
	$this->get('', function(Request $request, Response $response) {
		return $this->view->render($response, 'api.twig', [
			'desarrollador' => 'Alberto Jiménez Gibaja | alberto.jg@hotmail.es'
		]);
	});
	$this->group('/platos', function() {
		$this->get   ('',                       _Controller::class.':getAll');
		$this->get   ('/{id:[0-9]+}',           _Controller::class.':get');
		$this->post  ('',                       _Controller::class.':add');
		$this->put   ('/{id:[0-9]+}',           _Controller::class.':update');
		$this->delete('/{id:[0-9]+}',           _Controller::class.':delete');
		$this->get   ('/{id:[0-9]+}/alergenos', _Controller::class.':getAlergenos');
		$this->get   ('/{id:[0-9]+}/clonar',    _Controller::class.':clonarPlato');
	});
	$this->group('/ingredientes', function() {
		$this->get   ('',             _Controller::class.':getAll');
		$this->get   ('/{id:[0-9]+}', _Controller::class.':get');
		$this->post  ('',             _Controller::class.':add');
		$this->put   ('/{id:[0-9]+}', _Controller::class.':update');
		$this->delete('/{id:[0-9]+}', _Controller::class.':delete');
	});
	$this->group('/alergenos', function() {
		$this->get   ('',                  _Controller::class.':getAll');
		$this->get   ('/{id:[0-9]+}',      _Controller::class.':get');
		$this->post  ('',                  _Controller::class.':add');
		$this->put   ('/{id:[0-9]+}',      _Controller::class.':update');
		$this->delete('/{id:[0-9]+}',      _Controller::class.':delete');
		$this->get ('/{id:[0-9]+}/platos', _Controller::class.':getPlatos');
	});	
	$this->group('/ingredientes_alergenos', function() {
		$this->get('/{id_ingrediente:[0-9]+}',    _Controller::class.':get');
		$this->post('',                           _Controller::class.':add');
		$this->delete('/{id_ingrediente:[0-9]+}', _Controller::class.':delete');
	});
	$this->group('/platos_ingredientes', function() {
		$this->get('/{id_plato:[0-9]+}',    _Controller::class.':get');
		$this->post('',                     _Controller::class.':add');
		$this->delete('/{id_plato:[0-9]+}', _Controller::class.':delete');
	});	
});

<?php
use Slim\App;
use Slim\Http\Environment;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\RequestBody;
use Slim\Http\Response;
use Slim\Http\Uri;

class ApiTest extends PHPUnit_Framework_TestCase
{
	private $response;
    private $app;
	
	protected function request($method, $url, array $requestParameters = [])
    {
        $request = $this->prepareRequest($method, $url, $requestParameters);
        $response = new Response();
        $app = $this->app;
        $this->response = $app($request, $response);
    }

    protected function responseData()
    {
        return json_decode((string) $this->response->getBody(), true);
    }

    private function prepareRequest($method, $url, array $requestParameters)
    {
        $env = Environment::mock([
            'REQUEST_URI' => $url,
            'REQUEST_METHOD' => $method,
        ]);

        $parts = explode('?', $url);

        if (isset($parts[1])) {
            $env['QUERY_STRING'] = $parts[1];
        }

        $uri = Uri::createFromEnvironment($env);
        $headers = Headers::createFromEnvironment($env);
        $cookies = [];

        $serverParams = $env->all();

        $body = new RequestBody();
        $body->write(json_encode($requestParameters));

        $request = new Request($method, $uri, $headers, $cookies, $serverParams, $body);

        return $request->withHeader('Content-Type', 'application/json');
    }	
	
	protected function setUp()
    {
		require __DIR__.'/../app/app.php';
        $this->app = $app;
    }

    protected function tearDown()
    {
        $this->app = null;
        $this->response = null;
    }	
	
	// ALÉRGENOS
    public function testAlergenosInsertar()
    {
		$array_alergenos = array(
			array('id' =>  2, 'nombre' => 'Lactosa'),
			array('id' =>  3, 'nombre' => 'Fructosa'),
			array('id' =>  4, 'nombre' => 'Huevo'),
			array('id' =>  5, 'nombre' => 'Gluten'),
			array('id' => 11, 'nombre' => 'Apio'),
			array('id' => 12, 'nombre' => 'Marisco')
		);
		foreach ($array_alergenos as $alergeno) {
			$this->request('post', '/api/alergenos', $alergeno);
		}
    }
    public function testAlergenosListar()
    {
        $this->request('get', '/api/alergenos');
    }
	
	// INGREDIENTES
	public function testIngredientesInsertar()
    {
		$array_ingredientes = array(
			array('id' =>  1, 'nombre' => 'Queso'),
			array('id' =>  2, 'nombre' => 'Leche'),
			array('id' =>  4, 'nombre' => 'Chocolate'),
			array('id' =>  5, 'nombre' => 'Nata'),
			array('id' =>  6, 'nombre' => 'Mantequilla'),
			array('id' =>  7, 'nombre' => 'Fresas'),
			array('id' =>  8, 'nombre' => 'Manzana'),
			array('id' =>  9, 'nombre' => 'Harina de trigo'),
			array('id' => 10, 'nombre' => 'Levadura de trigo'),
			array('id' => 11, 'nombre' => 'Huevo'),
			array('id' => 12, 'nombre' => 'Fideos'),
			array('id' => 13, 'nombre' => 'Espaguetis'),
			array('id' => 14, 'nombre' => 'Puerro'),
			array('id' => 15, 'nombre' => 'Apio'),
			array('id' => 16, 'nombre' => 'Bacon'),
			array('id' => 17, 'nombre' => 'Picadillo de cerdo'),
			array('id' => 18, 'nombre' => 'Lentejas'),
			array('id' => 19, 'nombre' => 'Chorizo'),
			array('id' => 20, 'nombre' => 'Zanahoria'),
			array('id' => 21, 'nombre' => 'Cebolla'),
			array('id' => 22, 'nombre' => 'Ajo'),
			array('id' => 23, 'nombre' => 'Remolacha'),
			array('id' => 24, 'nombre' => 'Pan rallado'),
			array('id' => 25, 'nombre' => 'Filete de ternera'),
			array('id' => 26, 'nombre' => 'Gambas'),
			array('id' => 27, 'nombre' => 'Almejas'),
			array('id' => 28, 'nombre' => 'Ostras'),
			array('id' => 29, 'nombre' => 'Langostinos'),
			array('id' => 30, 'nombre' => 'Salsa de pescado'),
			array('id' => 31, 'nombre' => 'Secreto de cerdo ibérico'),
			array('id' => 32, 'nombre' => 'Carrilleras de cerdo'),
			array('id' => 33, 'nombre' => 'Placas de canelones')
		);
		foreach ($array_ingredientes as $ingrediente) {
			$this->request('post', '/api/ingredientes', $ingrediente);
		}
    }
    public function testIngredientesListar()
    {
        $this->request('get', '/api/ingredientes');
    }
	
	// PLATOS
	public function testPlatosInsertar()
    {
		$array_platos = array(
			array('id' =>  1, 'nombre' => 'Espaguetis a la carbonara'),
			array('id' =>  2, 'nombre' => 'Sopa de marisco'),
			array('id' =>  3, 'nombre' => 'Secreto ibérico al rulo de cabra'),
			array('id' =>  4, 'nombre' => 'Carrilleras de cerdo en salsa'),
			array('id' =>  5, 'nombre' => 'Canelones de verduras'),
			array('id' =>  6, 'nombre' => 'Ensalada de temporada'),
			array('id' =>  7, 'nombre' => 'Minestrone'),
			array('id' =>  8, 'nombre' => 'Escalopín de ternera')
		);
		foreach ($array_platos as $plato) {
			$this->request('post', '/api/platos', $plato);
		}
    }
    public function testPlatosListar()
    {
        $this->request('get', '/api/platos');
    }
	
	// RELACIONAR: Ingredientes-Alérgenos
	public function testRelacionarIngredientesAlergenos()
	{
		$array_relacional = array(
			array('id_ingrediente' =>  1, 'id_alergeno' =>  2), 
			array('id_ingrediente' =>  2, 'id_alergeno' =>  2), 
			array('id_ingrediente' =>  4, 'id_alergeno' =>  2), 
			array('id_ingrediente' =>  4, 'id_alergeno' =>  5), 
			array('id_ingrediente' =>  5, 'id_alergeno' =>  2), 
			array('id_ingrediente' =>  6, 'id_alergeno' =>  2), 
			array('id_ingrediente' =>  7, 'id_alergeno' =>  3), 
			array('id_ingrediente' =>  8, 'id_alergeno' =>  3), 
			array('id_ingrediente' =>  9, 'id_alergeno' =>  5), 
			array('id_ingrediente' => 10, 'id_alergeno' =>  5), 
			array('id_ingrediente' => 11, 'id_alergeno' =>  4), 
			array('id_ingrediente' => 12, 'id_alergeno' =>  4), 
			array('id_ingrediente' => 12, 'id_alergeno' =>  5), 
			array('id_ingrediente' => 13, 'id_alergeno' =>  4), 
			array('id_ingrediente' => 13, 'id_alergeno' =>  5), 
			array('id_ingrediente' => 14, 'id_alergeno' =>  3), 
			array('id_ingrediente' => 15, 'id_alergeno' =>  3), 
			array('id_ingrediente' => 15, 'id_alergeno' => 11), 
			array('id_ingrediente' => 18, 'id_alergeno' =>  3), 
			array('id_ingrediente' => 19, 'id_alergeno' =>  3), 
			array('id_ingrediente' => 20, 'id_alergeno' =>  3), 
			array('id_ingrediente' => 21, 'id_alergeno' =>  3), 
			array('id_ingrediente' => 22, 'id_alergeno' =>  3), 
			array('id_ingrediente' => 23, 'id_alergeno' =>  3), 
			array('id_ingrediente' => 24, 'id_alergeno' =>  5), 
			array('id_ingrediente' => 26, 'id_alergeno' => 12), 
			array('id_ingrediente' => 27, 'id_alergeno' => 12), 
			array('id_ingrediente' => 28, 'id_alergeno' => 12), 
			array('id_ingrediente' => 29, 'id_alergeno' => 12), 
			array('id_ingrediente' => 30, 'id_alergeno' => 12), 
			array('id_ingrediente' => 33, 'id_alergeno' =>  4), 
			array('id_ingrediente' => 33, 'id_alergeno' =>  5)
		);
		foreach ($array_relacional as $relacion) {
			$this->request('post', '/api/ingredientes_alergenos', $relacion);
		}
	}
	
	// RELACIONAR: Platos-Ingredientes
	public function testRelacionarPlatosIngredientes()
	{
		$array_relacional = array(
			array('id_plato' => 1, 'id_ingrediente' =>  5), 
			array('id_plato' => 1, 'id_ingrediente' => 13), 
			array('id_plato' => 2, 'id_ingrediente' => 12), 
			array('id_plato' => 2, 'id_ingrediente' => 21), 
			array('id_plato' => 2, 'id_ingrediente' => 22), 
			array('id_plato' => 2, 'id_ingrediente' => 26), 
			array('id_plato' => 2, 'id_ingrediente' => 27), 
			array('id_plato' => 2, 'id_ingrediente' => 30), 
			array('id_plato' => 3, 'id_ingrediente' =>  1), 
			array('id_plato' => 3, 'id_ingrediente' =>  9), 
			array('id_plato' => 3, 'id_ingrediente' => 31), 
			array('id_plato' => 4, 'id_ingrediente' =>  9), 
			array('id_plato' => 4, 'id_ingrediente' => 20), 
			array('id_plato' => 4, 'id_ingrediente' => 21), 
			array('id_plato' => 4, 'id_ingrediente' => 22), 
			array('id_plato' => 4, 'id_ingrediente' => 32), 
			array('id_plato' => 5, 'id_ingrediente' =>  1), 
			array('id_plato' => 5, 'id_ingrediente' => 14), 
			array('id_plato' => 5, 'id_ingrediente' => 15), 
			array('id_plato' => 5, 'id_ingrediente' => 20), 
			array('id_plato' => 5, 'id_ingrediente' => 21), 
			array('id_plato' => 5, 'id_ingrediente' => 22), 
			array('id_plato' => 5, 'id_ingrediente' => 33), 
			array('id_plato' => 6, 'id_ingrediente' =>  1),
			array('id_plato' => 6, 'id_ingrediente' =>  7),
			array('id_plato' => 6, 'id_ingrediente' =>  8),
			array('id_plato' => 6, 'id_ingrediente' => 11),
			array('id_plato' => 6, 'id_ingrediente' => 19),
			array('id_plato' => 6, 'id_ingrediente' => 20),
			array('id_plato' => 6, 'id_ingrediente' => 21),
			array('id_plato' => 6, 'id_ingrediente' => 22),
			array('id_plato' => 6, 'id_ingrediente' => 23),
			array('id_plato' => 6, 'id_ingrediente' => 26),
			array('id_plato' => 7, 'id_ingrediente' =>  1),
			array('id_plato' => 7, 'id_ingrediente' =>  7),
			array('id_plato' => 7, 'id_ingrediente' =>  8),
			array('id_plato' => 7, 'id_ingrediente' => 11),
			array('id_plato' => 7, 'id_ingrediente' => 19),
			array('id_plato' => 7, 'id_ingrediente' => 20),
			array('id_plato' => 7, 'id_ingrediente' => 21),
			array('id_plato' => 7, 'id_ingrediente' => 22),
			array('id_plato' => 7, 'id_ingrediente' => 23),
			array('id_plato' => 7, 'id_ingrediente' => 26),
			array('id_plato' => 8, 'id_ingrediente' => 11),
			array('id_plato' => 8, 'id_ingrediente' => 24),
			array('id_plato' => 8, 'id_ingrediente' => 25)
		);
		foreach ($array_relacional as $relacion) {
			$this->request('post', '/api/platos_ingredientes', $relacion);
		}
	}
	
	// Alérgeno: Platos
	public function testAlergenoPlatos() {
		$this->request('get', '/api/alergenos/2/platos');
		$this->request('get', '/api/alergenos/3/platos');
		$this->request('get', '/api/alergenos/4/platos');
		$this->request('get', '/api/alergenos/5/platos');
		$this->request('get', '/api/alergenos/11/platos');
		$this->request('get', '/api/alergenos/12/platos');
	}
	
	// Plato: Alérgenos
	public function testPlatoAlergenos() {
		$this->request('get', '/api/platos/1/alergenos');
		$this->request('get', '/api/platos/2/alergenos');
		$this->request('get', '/api/platos/3/alergenos');
		$this->request('get', '/api/platos/4/alergenos');
		$this->request('get', '/api/platos/5/alergenos');
		$this->request('get', '/api/platos/6/alergenos');
		$this->request('get', '/api/platos/7/alergenos');
		$this->request('get', '/api/platos/8/alergenos');
	}
	
	public function testClonarPlatos() {
		$this->request('get', '/api/platos/1/clonar');
		$this->request('get', '/api/platos/2/clonar');
		$this->request('get', '/api/platos/3/clonar');
		$this->request('get', '/api/platos/4/clonar');
		$this->request('get', '/api/platos/5/clonar');
		$this->request('get', '/api/platos/6/clonar');
		$this->request('get', '/api/platos/7/clonar');
		$this->request('get', '/api/platos/8/clonar');
	}
}

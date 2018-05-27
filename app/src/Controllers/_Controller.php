<?php
namespace App\Controllers;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\DataAccess\_DataAccess;

class _Controller
{
    protected $dataaccess;

    public function __construct(_DataAccess $dataaccess)
    {
        $this->dataaccess = $dataaccess;
    }
	
    public function clonarPlato(Request $request, Response $response, $args)
    {
		$id_plato = $args['id'];
		$result = $this->dataaccess->clonarPlato($id_plato);
		return $response->write(json_encode($result));
    }
	
    public function getAlergenos(Request $request, Response $response, $args)
    {
		$id_plato = $args['id'];
		$result = $this->dataaccess->getAlergenos($id_plato);
		return $response->write(json_encode($result));
    }
	
    public function getPlatos(Request $request, Response $response, $args)
    {
		$id_alergeno = $args['id'];
		$result = $this->dataaccess->getPlatos($id_alergeno);
		return $response->write(json_encode($result));
    }

    public function getAll(Request $request, Response $response, $args)
    {
        $path = explode('/', $request->getUri()->getPath())[2];
        $arrparams = $request->getParams();
		return $response->write(json_encode($this->dataaccess->getAll($path, $arrparams)));
    }

    public function get(Request $request, Response $response, $args)
    {
        $path = explode('/', $request->getUri()->getPath())[2];
        $result = $this->dataaccess->get($path, $args);
        return $response->write(json_encode($result));
    }

    public function add(Request $request, Response $response, $args)
    {
        $path = explode('/', $request->getUri()->getPath())[2];
        $request_data = $request->getParsedBody();
        $last_inserted_id = $this->dataaccess->add($path, $request_data);
		return $response->write(json_encode($last_inserted_id));
    }

    public function update(Request $request, Response $response, $args)
    {
        $path = explode('/', $request->getUri()->getPath())[2];
        $request_data = $request->getParsedBody();
        $isupdated = $this->dataaccess->update($path, $args, $request_data);
        return $response ->withStatus(200);
    }

    public function delete(Request $request, Response $response, $args)
    {
        $path = explode('/', $request->getUri()->getPath())[2];
        $isdeleted = $this->dataaccess->delete($path, $args);
        return $response ->withStatus(204);
    }
}

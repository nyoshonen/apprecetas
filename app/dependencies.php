<?php
use App\Controllers\_ApiController;
use App\Controllers\_Controller;
use App\DataAccess\_DataAccess;

$container = $app->getContainer();

$container['view'] = function ($container) {
   $view = new \Slim\Views\Twig(__DIR__ . '/../resources/views', [
	   'cache' => false,
   ]);
   $view->addExtension(new \Slim\Views\TwigExtension(
	   $container->router,
	   $container->request->getUri()
   ));
   return $view;
};
$container['pdo'] = function ($c) {
	$settings = $c->get('settings')['pdo'];
	return new PDO($settings['dsn'], $settings['username'], $settings['password']);
};
$container['App\Controllers\_ApiController'] = function ($c) {
	return new _ApiController();
};
$container['App\Controllers\_Controller'] = function ($c) {
	return new _Controller($c->get('App\DataAccess\_DataAccess'));
};
$container['App\DataAccess\_DataAccess'] = function ($c) {
	$localtable = $c->get('settings')['localtable']!='' ? $c->get('settings')['localtable'] : '';
	return new _DataAccess($c->get('pdo'), $localtable);
};

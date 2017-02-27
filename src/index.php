<?php 
use app\Application;
use handler\view\ViewHandler;
use handler\json\JsonHandler;
use handler\http\HttpStatusHandler;
use helpers\OODBBeanHandler;
use \RedBeanPHP\R;

include __DIR__ . '/../vendor/autoload.php';

$app = Application::create()
	->addHandler(new ViewHandler())
	->addHandler(new JsonHandler())
	->addHandler(new HttpStatusHandler())
	->addHandler(new OODBBeanHandler());

if (preg_match('#/([a-zA-Z]+)(/.*)?#i', $_SERVER['REQUEST_URI'], $matches)) {
	$resourceName = $matches[1];
	
	// setup database
	R::addDatabase('rest',  'sqlite:' . __DIR__ . "/db/$resourceName.db");
	R::selectDatabase('rest');
	
	$router = $app->getRouter();
	$resource = new \rest\resource\RestResource($resourceName);
	$resource->whiteList('DELETE', 'GET', 'HEAD', 'OPTIONS', 'PATCH', 'POST', 'PUT');
	new \rest\route\ResourceRoute($resource, $router);
}
	
return $app->start();

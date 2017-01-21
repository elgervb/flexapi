<?php 
use handler\view\ViewHandler;
use handler\json\JsonHandler;
use handler\http\HttpStatusHandler;
use helpers\OODBBeanHandler;

include __DIR__ . '/../vendor/autoload.php';

return Application::create()
	->addHandler(new ViewHandler())
	->addHandler(new JsonHandler())
	->addHandler(new HttpStatusHandler())
	->addHandler(new OODBBeanHandler())
	->addRoute('/', function() {
		echo 'Route for /';
	})
	->start();

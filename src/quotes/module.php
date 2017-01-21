<?php
use \RedBeanPHP\R;

return function (\router\Router $router) {
	R::setup( 'sqlite:./src/users/users.db' );
	
	$routes = include __DIR__ . '/routes.php';
	$routes($router);
};

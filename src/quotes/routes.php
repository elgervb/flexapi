<?php

use rest\resource\RestResource;
use rest\route\ResourceRoute;

return function(\router\Router $router) {
	$resource = new RestResource ( 'quotes' );
	$routes = new ResourceRoute($resource, $router);
};

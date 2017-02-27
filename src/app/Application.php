<?php
namespace app;

class Application {
	const DEFAULT_TIMEZONE = 'UTC';
	
	private $router;
	
	public function __construct($timezone = self::DEFAULT_TIMEZONE) {
		$this->setUp($timezone);
	}
	
	public static function create($timezone = self::DEFAULT_TIMEZONE) {
		return new Application($timezone);
	}
	
	public function addHandler(\handler\IHander $handler) {
		\handler\Handlers::get()->add($handler);
		
		return $this;
	}
	
	public function addRoute($path, \Closure $controller, $requestMethod = 'GET') {
		$this->getRouter();
		
		$this->router->route($path, $controller, $requestMethod);
		
		return $this;
	}
	
	public function getRouter() {
		if (!$this->router) {
			$this->router = new \router\Router();
		}
		
		return $this->router;
	}
	
	public function start($requestPath = null, $httpMethod = null) {
		if (!$requestPath) {
			$requestPath = $_SERVER['REQUEST_URI'];
		}
		if (!$httpMethod) {
			$httpMethod = $_SERVER['REQUEST_METHOD'];
		}
		
		$result = $this->getRouter()->match($requestPath, $httpMethod);
		
		return $this->handleActionResult($result);
	}
	
	private function handleActionResult($result) {
		
		$handlers = \handler\Handlers::get();
		$handler = $handlers->getHandler($result);
		if ($handler) {
			try {
				$handler->handle($result);
			} catch (\Exception $e) {
				$error = new HttpStatus(500, $e->getMessage());
				$handler = $handlers->getHandler($error);
				$handler->handle($error);
			}
		} else {
			$error = new \handler\http\HttpStatus(404, ' ');
			$handler = $handlers->getHandler($error);
			$handler->handle($error);
		}
		
		return $result;
	}
	
	
	private function setUp($timezone) {
		// initially turn on error reporting
		error_reporting(E_ALL);
		ini_set('display_errors', 'On');
		
		date_default_timezone_set($timezone);
		ini_set('date.timezone', $timezone);
	}
}
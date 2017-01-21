<?php
namespace helpers;

use handler\IHander;
use handler\json\Json;
use http\HttpContext;
use handler\Handlers;

/**
 * Handler to transform OODBBeans into JSON
 * 
 * @author elger van boxtel
 *
 */
class OODBBeanHandler implements IHander {
	
	/**
	 * {@inheritDoc}
	 * @see \handler\IHander::accept()
	 */
	public function accept($object) {
		return $object instanceof \RedBeanPHP\OODBBean;
	}

	/**
	 * {@inheritDoc}
	 * @see \handler\IHander::handle()
	 *
	 * @param $bean \RedBeanPHP\OODBBean
	 */
	public function handle($bean) {
		$array = $bean->export(false, false, true);
		$json = new Json($array);

		$handler = Handlers::get()->getHandler($json);
		if ($handler) { /* @var $handler \handler\IHander */
			return $handler->handle($json);
		}

		HttpContext::get()->getResponse()->flush();

		return $bean;
	}
}
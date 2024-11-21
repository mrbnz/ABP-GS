<?php

/*
 *       _____ _____ _____                _       _
 *      |_   _/  __ \_   _|              (_)     | |
 *        | | | /  \/ | |  ___  ___   ___ _  __ _| |
 *        | | ||      | | / __|/ _ \ / __| |/ _` | |
 *       _| |_| \__/\ | |_\__ \ (_) | (__| | (_| | |
 *      |_____\_____/ |_(_)___/\___/ \___|_|\__,_|_|
 *                   ___
 *                  |  _|___ ___ ___
 *                  |  _|  _| -_| -_|  LICENCE
 *                  |_| |_| |___|___|
 *
 * IT NEWS  <>  PROGRAMMING  <>  HW & SW  <>  COMMUNITY
 *
 * This source code is part of online courses at IT social
 * network WWW.ICT.SOCIAL
 *
 * Feel free to use it for whatever you want, modify it and share it but
 * don't forget to keep this link in code.
 *
 * For more information visit http://www.ict.social/licences
 *
 * Router is a special kind of controller which calls appropriate
 * controller according to the user's URL address. The router renders the view
 * of this particular controller into the layout template
 * Class RouterController
 */
class RouterController extends Controller
{
	/**
	 * @var Controller The inner controller instance
	 */
	protected $controller;

	/**
	 * Parses the URL address using slashes and returns params as array
	 * @param string $url The URL address to be parsed
	 * @return array The URL parameters
	 */
	private function parseUrl($url)
	{
		// Parses URL parts into an associative array
		$parsedUrl = parse_url($url);
		// Removes the leading slash
		$parsedUrl["path"] = ltrim($parsedUrl["path"], "/");
		// Removes white-spaces around the address
		$parsedUrl["path"] = trim($parsedUrl["path"]);
		// Splits the address by slashes
		$explodedUrl = explode("/", $parsedUrl["path"]);
		return $explodedUrl;
	}

	/**
	 * Converts dashed controller name from URL into a CamelCase class name
	 * @param string $text The controller name using dashes like article-list
	 * @return string The class name of the controller like ArticleList
	 */
	private function dashesToCamel($text)
	{
		$text = str_replace('-', ' ', $text);
		$text = ucwords($text);
		$text = str_replace(' ', '', $text);
		return $text;
	}

	/**
	 * Parses the URL address and creates appropriate controller
	 * @param array $params The URL address as an array of a single element
	 */
	public function process($params)
	{
		$parsedUrl = $this->parseUrl($params[0]);

		// Si 
		if (empty($parsedUrl[0])) {
//			$this->redirect(PGDEFAULT);
			$this->controller = new RouterController();
			$this->view = "layout";
			$this->head = array(
					'title' => TITOL,
					'description' => DESCRIPCIO,
			);
			$this->controller->view = "index2";
			
		}
		else {
			// The controller name is the 1st URL parameter
			$controllerClass = $this->dashesToCamel(array_shift($parsedUrl)) . 'Controller';
			if (file_exists('bundle/' . str_replace("Controller", "", $controllerClass) .'/controllers/' . $controllerClass . '.php')) {
				$this->controller = new $controllerClass;
			}
			else {
//				$this->redirect(ERRDEFAULT);
				$this->renderView("ERROR");
				exit;
			}

			// Calls the controller
			$this->controller->process($parsedUrl);
			// Setting template variables
			if (isset($this->controller->head['title']))
				$this->head['title'] = $this->controller->head['title'];
			$this->head['description'] = $this->controller->head['description'];
			// Sets the main template
			$this->view = 'layout';
		}
	}
}
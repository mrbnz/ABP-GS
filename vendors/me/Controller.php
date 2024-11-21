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
 */

/**
 * A base controller for ICT.social MVC
 * Class Controller
 */
abstract class Controller
{
    /**
     * @var array An array which indexes will be accessible as variables in template
     */
    protected $data = array();
    /**
     * @var string A template name without the extension
     */
    protected $view = "";
    /**
     * @var array The HTML head
     */
	protected $head = array('title' => '', 'description' => '');
	/**
	* @var  per a la vista
	**/
	protected $twig = false;

    /**
     * Protects any variable by converting HTML special characters to entities
     * @param mixed $x The variable to be protected
     * @return mixed The protected variable
     */
    private function protect($x = null)
    {
        if (!isset($x))
            return null;
        elseif (is_string($x))
            return htmlspecialchars($x, ENT_QUOTES);
        elseif (is_array($x))
        {
            foreach($x as $k => $v)
            {
                $x[$k] = $this->protect($v);
            }
            return $x;
        }
        else
            return $x;
    }

    /**
     * Renders the view
     */
    public function renderView($error = null)
   {
		// cas de pàgina d'Errada
		if ($error == "ERROR") {
			$this->twig = "error.html";
			//$loader = new Twig_Loader_Filesystem("./bundle");
			//$twig = new Twig_Environment($loader, array(
			$loader2 = new \Twig\Loader\FilesystemLoader("./bundle");
			$twig = new \Twig\Environment($loader2, array(	
			//'cache' => './cache',
			'cache' => false,
			'autoreload' => true,
			));
			//$twig->getExtension('core')->setTimezone('Europe/Andorra');
			$template = $twig->load($this->twig);
			$HTMLCOS = $template->render($this->data);
			
		} else if (get_class($this->controller) == "RouterController") {
			$this->twig = "index.html";
			$loader2 = new \Twig\Loader\FilesystemLoader("./bundle");
			$twig = new \Twig\Environment($loader2, array(			
			//'cache' => './cache',
			'cache' => false,
			'autoreload' => true,
			));
			//$twig->getExtension('core')->setTimezone('Europe/Andorra');
			$template = $twig->load($this->twig);
			$HTMLCOS = $template->render($this->data);
		} else {
			$this->twig = "layout.html";
			//$loader = new Twig_Loader_Filesystem("./bundle/" . str_replace("Controller", "", get_class($this->controller)) . "/templates");
			//$twig = new Twig_Environment($loader, array(
			$loader2 = new \Twig\Loader\FilesystemLoader("./bundle/" . str_replace("Controller", "", get_class($this->controller)) . "/templates");
			$twig = new \Twig\Environment($loader2, array(	
			//'cache' => './cache',
			'cache' => false,
			'autoreload' => true,
			));
			//$twig->getExtension('core')->setTimezone('Europe/Andorra');
			$template = $twig->load($this->controller->twig);
			$HTMLCOS = $template->render($this->controller->data);
		}
		
		//preparem i carreguem la interfície Layout
		//$loader2 = new Twig_Loader_Filesystem(DIRBASE . "/vendors/me");
		$loader2 = new \Twig\Loader\FilesystemLoader(DIRBASE . "/vendors/me");
		$twig2 = new \Twig\Environment($loader2, array(
		//'cache' => './cache',
		'cache' => false,
		'autoreload' => true,
		));
		//$twig2->getExtension('core')->setTimezone('Europe/Andorra');
		// $DATA = $this->controller->data;
		$DATA['ESTILS'] = ESTILS;
		$DATA['TITOL'] = TITOL;
		$DATA['DESCRIPCIO'] = DESCRIPCIO;
		$DATA['WEBBASE'] = WEBBASE;
		
		//Miro si tinc dades en el head
		if(isset($this->controller->head["title"])){
			 $DATA['TITOL'] = $this->controller->head["title"];
		}
		if(isset($this->controller->head["description"])){
			 $DATA['DESCRIPCIO'] = $this->controller->head["description"];
		}

		foreach($this->controller->data as $k => $v) $DATA[$k] = $v;
		$DATA['HTMLCOS'] = $HTMLCOS;

		$template = $twig2->load("layout.html");
		$HTMLBASE = $template->render($DATA);

		echo $HTMLBASE;
		
	} 

	/**
     * @param string $url Redirects to a given URL
     */
	public function redirect($url)
	{
		header("Location: ".WEBROOT."$url");
		header("Connection: close");
        exit;
	}

    /**
     * The main controller method
     * @param array $params URL parameters
     */
    abstract function process($params);

}

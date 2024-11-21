<?php
/**
 * Gestiona les sol·licituds de Editorial
 * Class EditorialController
 */
class EditorialController extends Controller
{
	public function process($params)
	{
		// Cal comprovar d'on venim i si volem afegir o no algun editorial.
		if (isset($_POST["submit"]) and (!empty($_POST["idEditorial"]))) {
			$editorial = new EditorialManager($_POST);
			
			$files = $editorial->updateBD();

			// HTML head
			$this->head = array(
					'title' => "Dades de l'editorial " . $editorial->nomEditorial,
					'description' => $files .  " registre modificat " . $editorial->nomEditorial,
			);
			$this->mostraTots();
			
			
		} else if (isset($_POST["submit"])) {
			$editorial = new EditorialManager($_POST);
			$files = $editorial->insertBD();

			// HTML head
			$this->head = array(
					'title' => "Dades de l'editorial " . $editorial->nomEditorial,
					'description' => $files .  " registre afegit " . $editorial->nomEditorial,
			);
			$this->mostraTots();
		} else if (isset($_POST["elimina"]) and isset($_POST["idEditorial"])) {
			$editorial = new EditorialManager($_POST);
			$files = $editorial->deleteBD();

			// HTML head
			$this->head = array(
					'title' => "Registre eliminat " . $editorial->nomEditorial,
					'description' => $files .  " eliminats " . $editorial->nomEditorial,
			);
			$this->mostraTots();
			
			
		} else if (isset($_POST["cancela"]) and isset($_POST["idEditorial"])) {
			// Setting the template
			$this->mostraTots();
//			$this->redirect(PGDEFAULT);
			
			
		} else {
			// Creating a model instance which allows us to access articles
			$editorialMNG = new EditorialManager();
			// The URL for displaying editorial is entered
			if (!empty($params[0]))
			{
				// Retrieving an editorial by the URL
				$editorial = $editorialMNG->selectEditorialBD($params[0]);
				// If no editorial was found we redirect to the ErrorController
				if (!$editorial)
					$this->redirect(ERRDEFAULT);

				// HTML head
				$this->head = array(
						'title' => "Dades de l'editorial " . $editorial->nomEditorial,
						'description' => "Dades de l'editorial " . $editorial->nomEditorial,
				);
				// Setting template variables
				$this->data = $editorial->getEditorial();
				// Setting the template
				$this->twig = 'editorialUn.html';
			}
			else
				// No URL entered so we list all articles
			{
				// HTML head
				//$this->head = array(
				//		'title' => "Llistat d'editorials",
				//		'description' => "ordenat per nomEditorial",
				//);
				$this->mostraTots();
			}
		}
	}
	private function mostraTots() {
		$editorialMNG = new EditorialManager();
		$editorials = $editorialMNG->selectEditorialsBD();
		foreach($editorials as $editorial) {
			$this->data['editorials'][] = $editorial->getEditorial();
		}
		$this->twig = 'editorialsTots.html';
	}
}
<?php

class ActivitatController extends Controller
{
    public function process($params)
    {
        switch (true) {
            case isset($params[0]) && is_numeric($params[0]):
                $this->mostraUnaActivitat($params[0]);
                break;
            case isset($params[0]) && $params[0] === 'veureActivitatsAdmin':
                $this->mostraTotesLesActivitats();
                $this->twig = "veure_activitat_admin.html"; // Mostra la plantilla per defecte
                break;
            case isset($params[0]) && $params[0] === 'afegirActivitat': // Afegit isset per evitar errors
                $this->afegirActivitat();
                break;
            default:
                $this->mostraTotesLesActivitats();
                $this->mostraFiltres();
                $this->twig = "activitat.html"; // Mostra la plantilla per defecte
                break;
        }
    }

    public function mostraFiltres (){
        $tipusActivitatMNG = new TipusActivitatManager();
        $this->data['llistaTipus'] = $tipusActivitatMNG->selectAll();
        $espaiMNG = new EspaiManager();
        $this->data['llistaEspai'] = $espaiMNG->selectAll();
    }

    public function mostraTotesLesActivitats(){
        $activitatMNG = new ActivitatManager();
		$activitatLlista = $activitatMNG->selectAll();
		
		if (is_array($activitatLlista)) {
			$this->data['activitatLlista'] = $activitatLlista;
		} else {
			$this->data['activitatLlista'] = [];
		}
    }
    public function filtrarActivitats(){
        
    }

    public function mostraUnaActivitat($id)
    {
        $activitatMNG = new ActivitatManager();
        $activitat = $activitatMNG->getActivitatById($id);
        
        if ($activitat) {
            $this->data['activitat'] = $activitat;
            $this->twig = "detall_activitat.html"; // Assegura't de tenir aquesta plantilla
        } else {
            $this->data['error'] = "Activitat no trobada.";
            $this->twig = "activitat.html"; // Mostra la plantilla per defecte
        }
    }
    public function afegirActivitat()
    {
        $espaiMNG = new EspaiManager();
        $this->data['llistaEspai'] = $espaiMNG->selectAll();

        $usuariMNG = new UsuariManager();
        $this->data['llistaOrganitzador'] = $usuariMNG->selectAllOrganitzadors();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'] ?? null;
            $descripcioBreu = $_POST['descripcio_breu'] ?? null;
            $descripcio = $_POST['descripcio'] ?? null;
            $data = $_POST['data'] ?? null;
            $placesTotals = $_POST['places_totals'] ?? null;
            $preu = $_POST['preu'] ?? null;
            $idEspai = $_POST['id_espai'] ?? null;
            $idOrganitzador = $_POST['id_organitzador'] ?? null;

            if ($nom && $descripcioBreu && $descripcio && $data && $placesTotals && $preu && $idEspai && $idOrganitzador) {
                $activitatMNG = new ActivitatManager();
                $idActivitat = $activitatMNG->addActivitat($nom, $descripcioBreu, $descripcio, $data, $placesTotals, $preu, $idEspai, $idOrganitzador);

                if ($idActivitat) {
                    $this->data['success'] = "Activitat afegida correctament.";

                    // Processar fotos
                    $rutaBase = '/var/www/html/exercicism07/ABP-GS/images/';
                    $multimediaMNG = new MultimediaManager();

                    if (isset($_FILES['fotos']) && $_FILES['fotos']['error'][0] == UPLOAD_ERR_OK) {
                        $fotos = $_FILES['fotos'];
                        for ($i = 0; $i < count($fotos['name']); $i++) {
                            $nomFitxer = basename($fotos['name'][$i]);
                            $rutaDesti = $rutaBase . $nomFitxer;
                            if (move_uploaded_file($fotos['tmp_name'][$i], $rutaDesti)) {
                                $idMultimedia = $multimediaMNG->addMultimedia($rutaDesti, 'imatge', 'Foto de l\'activitat', 'actiu');
                                $activitatMNG->addActivitatMultimedia($idActivitat, $idMultimedia);
                            } else {
                                $this->data['error'] = "Error en pujar la foto: " . $nomFitxer;
                            }
                        }
                    }

                    if (isset($_FILES['foto_portada']) && $_FILES['foto_portada']['error'] == UPLOAD_ERR_OK) {
                        $nomFitxerPortada = basename($_FILES['foto_portada']['name']);
                        $rutaPortada = $rutaBase . $nomFitxerPortada;
                        if (move_uploaded_file($_FILES['foto_portada']['tmp_name'], $rutaPortada)) {
                            $idMultimedia = $multimediaMNG->addMultimedia($rutaPortada, 'imatge', 'Foto de portada', 'actiu');
                            $activitatMNG->addActivitatMultimedia($idActivitat, $idMultimedia);
                        } else {
                            $this->data['error'] = "Error en pujar la foto de portada.";
                        }
                    }
                } else {
                    $this->data['error'] = "Error en afegir l'activitat.";
                }
            } else {
                $this->data['error'] = "Falten dades!";
            }
        }

        $this->twig = 'afegir_activitat.html';
    }
}
?>
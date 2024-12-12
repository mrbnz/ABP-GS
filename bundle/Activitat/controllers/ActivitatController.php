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
            case isset($params[0]) && $params[0] === 'editarActivitat' && isset($params[1]) && is_numeric($params[1]):
                $this->editarActivitat($params[1]);
                break;
            case isset($params[0]) && $params[0] === 'llistaActivitatsPerEditar':
                $this->llistaActivitatsPerEditar();
                break;
            case isset($params[0]) && $params[0] === 'assignarOrganitzador' && isset($params[1]) && is_numeric($params[1]):
                $this->assignarOrganitzador($params[1]);
                break;
            case isset($params[0]) && $params[0] === 'gestionarInscripcions' && isset($params[1]) && is_numeric($params[1]):
                $this->gestionarInscripcions($params[1]);
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
        $ActivitatTipusMNG = new ActivitatTipusManager();
        $this->data['llistaActivitatTipus'] = $ActivitatTipusMNG->selectAll();
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

        // Debug de la foto
        if (isset($activitat['imatge'])) {
            $this->data['activitat']['imatge'] = $activitat['imatge'];
        } else {
            $this->data['activitat']['imatge'] = null;
        }
    }
    public function afegirActivitat()
    {
        $espaiMNG = new EspaiManager();
        $this->data['llistaEspai'] = $espaiMNG->selectAll();

        $usuariMNG = new UsuariManager();
        $this->data['llistaOrganitzador'] = $usuariMNG->selectAllOrganitzadors();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validació de dades
            $validacio = $this->validarDadesActivitat($_POST);
            if ($validacio === true) {
                // Procés d'afegir activitat
                $nom = $_POST['nom'] ?? '';
                $descripcioBreu = $_POST['descripcio_breu'] ?? '';
                $descripcio = $_POST['descripcio'] ?? '';
                $data = $_POST['data'] ?? '';
                $placesTotals = $_POST['places_totals'] ?? '';
                $preu = $_POST['preu'] ?? '';
                $idEspai = $_POST['id_espai'] ?? '';
                $idOrganitzador = $_POST['id_organitzador'] ?? '';

                $activitatMNG = new ActivitatManager();
                $idActivitat = $activitatMNG->addActivitat($nom, $descripcioBreu, $descripcio, $data, $placesTotals, $preu, $idEspai, $idOrganitzador);
                
                if ($idActivitat) {
                    $this->data['success'] = "Activitat afegida correctament.";
                    
                    // Processar la foto si s'ha pujat
                    if (isset($_FILES['foto_portada']) && $_FILES['foto_portada']['error'] == UPLOAD_ERR_OK) {
                        $rutaBase = 'images/';
                        if (!is_dir($rutaBase)) {
                            mkdir($rutaBase, 0777, true);
                        }   
                        
                        $rutaPortada = $rutaBase . basename($_FILES['foto_portada']['name']);
                        $multimediaMNG = new MultimediaManager();
                        
                        if (move_uploaded_file($_FILES['foto_portada']['tmp_name'], $rutaPortada)) {
                            $idMultimedia = $multimediaMNG->addMultimedia($rutaPortada, 'imatge', 'Foto de portada', 'actiu');
                            if ($idMultimedia) {
                                $activitatMNG->addActivitatMultimedia($idActivitat, $idMultimedia);
                            } else {
                                $this->data['error'] = "Error al guardar la informació de la imatge.";
                            }
                        } else {
                            $this->data['error'] = "Error al moure el fitxer pujat.";
                        }
                    } else {
                        $this->data['error'] = "No s'ha pujat cap foto o hi ha hagut un error en la pujada.";
                    }
                } else {
                    $this->data['error'] = "Error al afegir l'activitat.";
                }
            } else {
                $this->data['error'] = $validacio; // Mostra l'error de validació
            }
        }

        $this->twig = 'afegir_activitat.html';
    }

    public function editarActivitat($id)
    {
        $activitatMNG = new ActivitatManager();
        $activitat = $activitatMNG->getActivitatById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nomActivitat'] ?? null;
            $descripcio = $_POST['descripcio'] ?? null;
            $descripcioBreu = $_POST['descripcioBreu'] ?? null;
            $data = $_POST['data'] ?? null;
            $placesTotals = $_POST['placesTotals'] ?? null;
            $preu = $_POST['preu'] ?? null;

            if ($nom && $descripcio && $descripcioBreu && $data && $placesTotals && $preu) {
                $success = $activitatMNG->updateActivitat($id, $nom, $descripcio, $descripcioBreu, $data, $placesTotals, $preu);
                if ($success) {
                    $this->data['success'] = "Activitat actualitzada correctament.";
                } else {
                    $this->data['error'] = "Error en actualitzar l'activitat.";
                }
            } else {
                $this->data['error'] = "Falten dades!";
            }
        }

        if ($activitat) {
            $this->data['activitat'] = $activitat;
            $this->twig = 'editar_activitat.html';
        } else {
            $this->data['error'] = "Activitat no trobada.";
            $this->twig = 'activitat.html';
        }
    }

    public function llistaActivitatsPerEditar()
    {
        $activitatMNG = new ActivitatManager();
        $activitatLlista = $activitatMNG->selectAll();

        if (is_array($activitatLlista)) {
            $this->data['activitatLlista'] = $activitatLlista;
        } else {
            $this->data['activitatLlista'] = [];
        }

        $this->twig = "llista_activitats_editar.html"; // Assegura't de crear aquesta plantilla
    }

    public function assignarOrganitzador($idActivitat)
    {
        $usuariMNG = new UsuariManager();
        $this->data['llistaUsuaris'] = $usuariMNG->getAllUsers();
        $this->data['activitatId'] = $idActivitat;
        $this->twig = 'assignar_organitzador.html';
    }

    public function gestionarInscripcions($idActivitat)
    {
        $inscripcioMNG = new InscripcioManager();
        $usuariMNG = new UsuariManager();
        $this->data['inscrits'] = $inscripcioMNG->getInscritsByActivitat($idActivitat);
        $this->data['llistaUsuaris'] = $usuariMNG->getAllUsers();
        $this->data['activitatId'] = $idActivitat;
        $this->twig = 'gestionar_inscripcions.html';
    }

    public function assignarOrganitzadorPost($idActivitat)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['userId'] ?? null;
            if ($userId) {
                $organitzadorMNG = new OrganitzadorManager();
                $organitzadorMNG->assignarOrganitzador($idActivitat, $userId);
                $this->data['success'] = "Organitzador assignat correctament.";
            } else {
                $this->data['error'] = "Falten dades!";
            }
        }
        $this->assignarOrganitzador($idActivitat);
    }

    public function afegirInscripcio($idActivitat)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['userId'] ?? null;
            if ($userId) {
                $inscripcioMNG = new InscripcioManager();
                $inscripcioMNG->afegirInscripcio($idActivitat, $userId);
                $this->data['success'] = "Usuari inscrit correctament.";
            } else {
                $this->data['error'] = "Falten dades!";
            }
        }
        $this->gestionarInscripcions($idActivitat);
    }

    private function validarDadesActivitat($dades) {
        $errors = [];
        
        if (empty($dades['nom'])) $errors[] = "El nom és obligatori";
        if (empty($dades['descripcio_breu'])) $errors[] = "La descripció breu és obligatòria";
        if (empty($dades['descripcio'])) $errors[] = "La descripció és obligatòria";
        if (empty($dades['data'])) $errors[] = "La data és obligatòria";
        if (empty($dades['places_totals']) || !is_numeric($dades['places_totals'])) $errors[] = "Les places totals han de ser un número vàlid";
        if (empty($dades['preu']) || !is_numeric($dades['preu'])) $errors[] = "El preu ha de ser un número vàlid";
        if (empty($dades['id_espai'])) $errors[] = "Cal seleccionar un espai";
        //if (empty($dades['id_organitzador'])) $errors[] = "Cal seleccionar un organitzador";
        
        if (!empty($errors)) {
            $this->data['errors'] = $errors;
            return false;
        }
        
        //$this->data['validacio_ok'] = "Totes les dades són correctes!";
        return true;
    }

}
?>
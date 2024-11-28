<?php
class ActivitatMultimedia
{
    // Camps de la base de dades
    private $idActivitat;
    private $idMultimedia;

    // Constructor
    public function __construct($valors = null)
    {
        if ($valors === null) {
            $this->idActivitat = null;
            $this->idMultimedia = null;
        } else if (is_array($valors)) {
            if (isset($valors["idActivitat"])) $this->idActivitat = $valors["idActivitat"];
            if (isset($valors["idMultimedia"])) $this->idMultimedia = $valors["idMultimedia"];
        }
    }

    // Getters i setters
    public function getIdActivitat()
    {
        return $this->idActivitat;
    }

    public function setIdActivitat($idActivitat)
    {
        if (isset($idActivitat)) $this->idActivitat = $idActivitat;
    }

    public function getIdMultimedia()
    {
        return $this->idMultimedia;
    }

    public function setIdMultimedia($idMultimedia)
    {
        if (isset($idMultimedia)) $this->idMultimedia = $idMultimedia;
    }

    // Mètode __toString per representar l'objecte com a cadena
    public function __toString()
    {
        return "ActivitatMultimedia [idActivitat=$this->idActivitat, idMultimedia=$this->idMultimedia]";
    }
}
?>

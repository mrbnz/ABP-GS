<?php
class ActivitatRelTipus
{
    // Camps de la base de dades
    private $idActivitat;
    private $idTipusActivitat;

    // Constructor
    public function __construct($valors = null)
    {
        if ($valors === null) {
            $this->idActivitat = null;
            $this->idTipusActivitat = null;
        } else if (is_array($valors)) {
            if (isset($valors["idActivitat"])) $this->idActivitat = $valors["idActivitat"];
            if (isset($valors["idTipusActivitat"])) $this->idTipusActivitat = $valors["idTipusActivitat"];
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

    public function getIdTipusActivitat()
    {
        return $this->idTipusActivitat;
    }

    public function setIdTipusActivitat($idTipusActivitat)
    {
        if (isset($idTipusActivitat)) $this->idTipusActivitat = $idTipusActivitat;
    }

    // Mètode __toString per representar l'objecte com a cadena
    public function __toString()
    {
        return "ActivitatRelTipus [idActivitat=$this->idActivitat, idTipusActivitat=$this->idTipusActivitat]";
    }
}
?>

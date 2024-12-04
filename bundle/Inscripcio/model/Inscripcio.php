<?php
class Inscripcio
{
    // Camps de la base de dades
    private $idUsuari;
    private $idActivitat;
    private $estat;
    private $dataCreacio;

    // Constructor
    public function __construct($valors = null)
    {
        if ($valors === null) {
            $this->idUsuari = null;
            $this->idActivitat = null;
            $this->estat = null;
            $this->dataCreacio = null;
        } else if (is_array($valors)) {
            if (isset($valors["idUsuari"])) $this->idUsuari = $valors["idUsuari"];
            if (isset($valors["idActivitat"])) $this->idActivitat = $valors["idActivitat"];
            if (isset($valors["estat"])) $this->estat = $valors["estat"];
            if (isset($valors["dataCreacio"])) $this->dataCreacio = $valors["dataCreacio"];
        }
    }

    // Getters i setters
    public function getIdUsuari()
    {
        return $this->idUsuari;
    }

    public function setIdUsuari($idUsuari)
    {
        if (isset($idUsuari)) $this->idUsuari = $idUsuari;
    }

    public function getIdActivitat()
    {
        return $this->idActivitat;
    }

    public function setIdActivitat($idActivitat)
    {
        if (isset($idActivitat)) $this->idActivitat = $idActivitat;
    }

    public function getEstat()
    {
        return $this->estat;
    }

    public function setEstat($estat)
    {
        if (isset($estat)) $this->estat = $estat;
    }

    public function getDataCreacio()
    {
        return $this->dataCreacio;
    }

    public function setDataCreacio($dataCreacio)
    {
        if (isset($dataCreacio)) $this->dataCreacio = $dataCreacio;
    }

    // Mètode __toString per representar l'objecte com a cadena
    public function __toString()
    {
        return "Inscripcio [idUsuari=$this->idUsuari, idActivitat=$this->idActivitat, estat=$this->estat, dataCreacio=$this->dataCreacio]";
    }
}
?>

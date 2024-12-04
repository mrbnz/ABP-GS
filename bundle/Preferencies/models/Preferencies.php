<?php
class Preferencies
{
    // Camps de la base de dades
    private $idUsuari;
    private $idTipusActivitat;
    private $dataRegistrada;

    // Constructor
    public function __construct($valors = null)
    {
        if ($valors === null) {
            $this->idUsuari = null;
            $this->idTipusActivitat = null;
            $this->dataRegistrada = null;
        } else if (is_array($valors)) {
            if (isset($valors["idUsuari"])) $this->idUsuari = $valors["idUsuari"];
            if (isset($valors["idTipusActivitat"])) $this->idTipusActivitat = $valors["idTipusActivitat"];
            if (isset($valors["dataRegistrada"])) $this->dataRegistrada = $valors["dataRegistrada"];
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

    public function getIdTipusActivitat()
    {
        return $this->idTipusActivitat;
    }

    public function setIdTipusActivitat($idTipusActivitat)
    {
        if (isset($idTipusActivitat)) $this->idTipusActivitat = $idTipusActivitat;
    }

    public function getDataRegistrada()
    {
        return $this->dataRegistrada;
    }

    public function setDataRegistrada($dataRegistrada)
    {
        if (isset($dataRegistrada)) $this->dataRegistrada = $dataRegistrada;
    }

    // Mètode __toString per representar l'objecte com a cadena
    public function __toString()
    {
        return "Preferencies [idUsuari=$this->idUsuari, idTipusActivitat=$this->idTipusActivitat, dataRegistrada=$this->dataRegistrada]";
    }
}
?>

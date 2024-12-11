<?php

class InscripcioManager
{
    public function afegirInscripcio($idActivitat, $idUsuari)
    {
        try {
            $consulta = (BdD::$connection)->prepare('
                INSERT INTO inscripcions (id_activitat, id_usuari) VALUES (:idActivitat, :idUsuari)
            ');
            $consulta->bindValue(':idActivitat', $idActivitat, PDO::PARAM_INT);
            $consulta->bindValue(':idUsuari', $idUsuari, PDO::PARAM_INT);
            return $consulta->execute();
        } catch (PDOException $e) {
            echo "***Error***: " . $e->getMessage();
            return false;
        }
    }

    public function getInscritsByActivitat($idActivitat)
    {
        try {
            $consulta = (BdD::$connection)->prepare('
                SELECT * FROM usuaris WHERE id IN (SELECT id_usuari FROM inscripcions WHERE id_activitat = :idActivitat)
            ');
            $consulta->bindValue(':idActivitat', $idActivitat, PDO::PARAM_INT);
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "***Error***: " . $e->getMessage();
            return [];
        }
    }
} 
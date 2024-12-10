<?php

class OrganitzadorManager
{
    public function assignarOrganitzador($idActivitat, $idUsuari)
    {
        try {
            $consulta = (BdD::$connection)->prepare('
                UPDATE activitat SET id_organitzador = :idUsuari WHERE id = :idActivitat
            ');
            $consulta->bindValue(':idUsuari', $idUsuari, PDO::PARAM_INT);
            $consulta->bindValue(':idActivitat', $idActivitat, PDO::PARAM_INT);
            return $consulta->execute();
        } catch (PDOException $e) {
            echo "***Error***: " . $e->getMessage();
            return false;
        }
    }

    public function selectAll()
    {
        try {
            $consulta = (BdD::$connection)->query('SELECT * FROM organitzador');
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "***Error***: " . $e->getMessage();
            return [];
        }
    }
}

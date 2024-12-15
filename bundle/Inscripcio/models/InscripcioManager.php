<?php

class InscripcioManager
{
    public function afegirInscripcio($idActivitat, $idUsuari)
    {
        try {
            $consulta = (BdD::$connection)->prepare('
                INSERT INTO inscripcio (id_usuari, id_activitat, estat) VALUES (:idUsuari, :idActivitat, :estat)
            ');
            $consulta->bindValue(':idUsuari', $idUsuari, PDO::PARAM_INT);
            $consulta->bindValue(':idActivitat', $idActivitat, PDO::PARAM_INT);
            $consulta->bindValue(':estat', 'confirmada', PDO::PARAM_STR);
            return $consulta->execute();
        } catch (PDOException $e) {
            echo "***Error***: " . $e->getMessage();
            return false;
        }
    }

    public function updateInscripcioEstat($idUsuari, $idActivitat, $nouEstat)
{
    $consulta = (BdD::$connection)->prepare('
        UPDATE inscripcio 
        SET estat = :nouEstat 
        WHERE id_usuari = :idUsuari AND id_activitat = :idActivitat
    ');

    $consulta->bindValue(':nouEstat', $nouEstat, PDO::PARAM_STR);
    $consulta->bindValue(':idUsuari', $idUsuari, PDO::PARAM_INT);
    $consulta->bindValue(':idActivitat', $idActivitat, PDO::PARAM_INT);
    
    return $consulta->execute();
}


    public function getInscritsByActivitat($idActivitat)
    {
        try {
            $consulta = (BdD::$connection)->prepare('
                SELECT * FROM usuaris WHERE id IN (SELECT id_usuari FROM inscripcio WHERE id_activitat = :idActivitat)
            ');
            $consulta->bindValue(':idActivitat', $idActivitat, PDO::PARAM_INT);
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "***Error***: " . $e->getMessage();
            return [];
        }
    }

    public function getInscriptionForUser($idUsuari, $idActivitat)
{
    try {
        $consulta = (BdD::$connection)->prepare('
            SELECT * 
            FROM inscripcio
            WHERE id_usuari = :idUsuari AND id_activitat = :idActivitat
        ');

        $consulta->bindValue(':idUsuari', $idUsuari, PDO::PARAM_INT);
        $consulta->bindValue(':idActivitat', $idActivitat, PDO::PARAM_INT);

        $consulta->execute();
        $resultat = $consulta->fetch(PDO::FETCH_ASSOC);

        // Si no hi ha cap resultat, retornem null
        return $resultat ?: null;
    } catch (PDOException $e) {
        echo "***Error***: " . $e->getMessage();
        return null; // Retornem null en cas d'error
    }
}

public function existeixUsuari($idUsuari)
{
    $consulta = (BdD::$connection)->prepare('SELECT COUNT(*) FROM usuari WHERE id = :idUsuari');
    $consulta->bindValue(':idUsuari', $idUsuari, PDO::PARAM_INT);
    $consulta->execute();
    return $consulta->fetchColumn() > 0;
}

} 
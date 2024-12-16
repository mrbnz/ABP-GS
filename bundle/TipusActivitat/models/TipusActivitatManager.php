<?php
class TipusActivitatManager extends TipusActivitat {
    public function selectAll() {
		$resposta = null;
			try {
				$consulta = (BdD::$connection)->prepare(
					'SELECT * FROM `tipus_activitat`'
					);
				$qFiles = $consulta->execute();
				if ($qFiles > 0) {
					$consulta->setFetchMode(PDO::FETCH_ASSOC); 
					$resposta = $consulta->fetchAll();
				}
			} catch(PDOException $e) {
				echo "***Error***: " . $e->getMessage();
			}
		return $resposta;
	}
}
?>
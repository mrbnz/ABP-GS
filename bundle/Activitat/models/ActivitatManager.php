<?php
class ActivitatManager extends Activitat {
    public function selectAll() {
		$resposta = null;
			try {
				$consulta = (BdD::$connection)->prepare(
					'SELECT * FROM `activitat`'
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
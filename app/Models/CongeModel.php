<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\SoldeModel;

class CongeModel extends Model
{
	protected $table = 'Conges';
	protected $primaryKey = 'id';
	protected $useAutoIncrement = true;
	protected $returnType = 'array';
	protected $allowedFields = ['employe_id', 'type_conge_id', 'date_debut', 'date_fin', 'nb_jours', 'motif', 'statut', 'commentaire_rh', 'traite_par'];
	protected $useTimestamps = true;
	protected $createdField = 'created_at';
	protected $updatedField = null;

	protected $validationRules = [
		'employe_id' => 'required|integer|greater_than[0]',
		'type_conge_id' => 'required|integer|greater_than[0]',
		'date_debut' => 'required|valid_date',
		'date_fin' => 'required|valid_date',
		'nb_jours' => 'required|integer|greater_than[0]',
		'motif' => 'required|string',
		'statut' => 'required|in_list[en_attente,approuve,rejete,annule]',
		'commentaire_rh' => 'permit_empty|string',
		'traite_par' => 'permit_empty|integer'
	];

	protected $validationMessages = [
		'statut' => ['in_list' => 'Le statut doit être: en_attente, approuve, rejete ou annule.']
	];

	protected $skipValidation = false;

	public function getEmploye($employeId)
	{
		return $this->db->table('Employes')->where('id', $employeId)->get()->getRowArray();
	}

	public function getTypeConge($typeCongeId)
	{
		return $this->db->table('Types_conges')->where('id', $typeCongeId)->get()->getRowArray();
	}

	public function getCongesByEmploye($employeId)
	{
		return $this->where('employe_id', $employeId)->join('Employes', 'Conges.employe_id = Employes.id')->join('Types_conges', 'Conges.type_conge_id = Types_conges.id')->findAll();
	}

	public function getCongesEnAttente()
	{
		return $this->where('statut', 'en_attente')->findAll();
	}

	public function approuverConge(int $congeId, int $rhId, int $annee, ?string $commentaire = null): bool
	{
		$this->db->transStart();

		$conge = $this->find($congeId);
		if (! $conge || $conge['statut'] !== 'en_attente') {
			$this->db->transRollback();
			return false;
		}

		$soldeModel = new SoldeModel();
		if (! $soldeModel->hasSoldeDisponible((int) $conge['employe_id'], (int) $conge['type_conge_id'], $annee, (int) $conge['nb_jours'])) {
			$this->db->transRollback();
			return false;
		}

		$solde = $soldeModel->getSolde((int) $conge['employe_id'], (int) $conge['type_conge_id'], $annee);
		if (! $solde) {
			$this->db->transRollback();
			return false;
		}

		$okConge = $this->update($congeId, [
			'statut' => 'approuve',
			'commentaire_rh' => $commentaire ?? '',
			'traite_par' => $rhId,
		]);

		if (! $okConge) {
			$this->db->transRollback();
			return false;
		}

		$okSolde = $soldeModel->updateJoursPris((int) $solde['id'], (int) $conge['nb_jours']);
		if (! $okSolde) {
			$this->db->transRollback();
			return false;
		}

		$this->db->transComplete();

		return $this->db->transStatus();
	}

	public function refuserConge(int $congeId, int $rhId, ?string $commentaire = null): bool
	{
		$conge = $this->find($congeId);
		if (! $conge || $conge['statut'] !== 'en_attente') {
			return false;
		}

		return (bool) $this->update($congeId, [
			'statut' => 'refuse',
			'commentaire_rh' => $commentaire ?? '',
			'traite_par' => $rhId,
		]);
	}

	public function annulerConge(int $congeId, int $annee): bool
	{
		$this->db->transStart();

		$conge = $this->find($congeId);
		if (! $conge || $conge['statut'] === 'annule' || $conge['statut'] === 'refuse') {
			$this->db->transRollback();
			return false;
		}

		$okConge = $this->update($congeId, ['statut' => 'annule']);
		if (! $okConge) {
			$this->db->transRollback();
			return false;
		}

		if ($conge['statut'] === 'approuve') {
			$soldeModel = new SoldeModel();
			$solde = $soldeModel->getSolde((int) $conge['employe_id'], (int) $conge['type_conge_id'], $annee);
			if (! $solde) {
				$this->db->transRollback();
				return false;
			}

			$okSolde = $soldeModel->updateJoursPris((int) $solde['id'], -((int) $conge['nb_jours']));
			if (! $okSolde) {
				$this->db->transRollback();
				return false;
			}
		}

		$this->db->transComplete();

		return $this->db->transStatus();
	}
}

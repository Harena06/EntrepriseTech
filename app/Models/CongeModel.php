<?php

namespace App\Models;

use CodeIgniter\Model;

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
		'traite_par' => 'integer'
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
		return $this->where('employe_id', $employeId)->findAll();
	}

	public function getCongesEnAttente()
	{
		return $this->where('statut', 'en_attente')->findAll();
	}
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class SoldeModel extends Model
{
    protected $table = 'Soldes';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['employe_id', 'type_conge_id', 'annee', 'jours_attribues', 'jours_pris'];

    protected $validationRules = [
        'employe_id' => 'required|integer|greater_than[0]',
        'type_conge_id' => 'required|integer|greater_than[0]',
        'annee' => 'required|integer|min_length[4]|max_length[4]',
        'jours_attribues' => 'required|integer|greater_than_equal_to[0]',
        'jours_pris' => 'required|integer|greater_than_equal_to[0]'
    ];

    protected $validationMessages = [
        'employe_id' => ['required' => "L'identifiant employé est requis."],
        'type_conge_id' => ['required' => 'Le type de congé est requis.'],
        'annee' => ['required' => "L'année est requise."]
    ];

    protected $skipValidation = false;

    public function getEmploye($employeId)
    {
        return $this->db->table('Employes')
            ->where('id', $employeId)
            ->get()
            ->getRowArray();
    }

    public function getTypeConge($typeCongeId)
    {
        return $this->db->table('Types_conges')
            ->where('id', $typeCongeId)
            ->get()
            ->getRowArray();
    }

    public function getSolde(int $employeId, int $typeCongeId, int $annee): ?array
    {
        return $this->where([
            'employe_id' => $employeId,
            'type_conge_id' => $typeCongeId,
            'annee' => $annee,
        ])->first();
    }

    public function hasSoldeDisponible(int $employeId, int $typeCongeId, int $annee, int $nbJours): bool
    {
        $solde = $this->getSolde($employeId, $typeCongeId, $annee);
        if (! $solde) {
            return false;
        }

        $restant = (int) $solde['jours_attribues'] - (int) $solde['jours_pris'];

        return $restant >= $nbJours;
    }

    public function updateJoursPris(int $soldeId, int $deltaJours): bool
    {
        $solde = $this->find($soldeId);
        if (! $solde) {
            return false;
        }

        $nouveau = (int) $solde['jours_pris'] + $deltaJours;
        if ($nouveau < 0) {
            return false;
        }

        return $this->update($soldeId, ['jours_pris' => $nouveau]);
    }
}

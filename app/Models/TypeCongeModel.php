<?php

namespace App\Models;

use CodeIgniter\Model;

class TypeCongeModel extends Model
{
    protected $table = 'Types_conges';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['libelle', 'jours_annuels', 'deductible'];

    protected $validationRules = [
        'libelle' => 'required|string|max_length[255]|is_unique[Types_conges.libelle]',
        'jours_annuels' => 'required|integer|greater_than[0]',
        'deductible' => 'integer|in_list[0,1]'
    ];

    protected $validationMessages = [
        'libelle' => [
            'is_unique' => 'Ce type de congé existe déjà.'
        ],
        'jours_annuels' => [
            'greater_than' => 'Le nombre de jours doit être supérieur à 0.'
        ]
    ];

    protected $skipValidation = false;
}

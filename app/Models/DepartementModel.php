<?php

namespace App\Models;

use CodeIgniter\Model;

class DepartementModel extends Model
{
    protected $table = 'Departements';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['nom', 'description'];

    protected $validationRules = [
        'nom' => 'required|string|max_length[255]|is_unique[Departements.nom]',
        'description' => 'required|string|max_length[1000]'
    ];

    protected $validationMessages = [
        'nom' => [
            'is_unique' => 'Ce département existe déjà.'
        ]
    ];

    protected $skipValidation = false;
}

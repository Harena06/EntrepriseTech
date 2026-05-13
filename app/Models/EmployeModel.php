<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeModel extends Model{
    protected $table = 'Employes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'email', 'mot_de_passe', 'role', 'departement', 'date_embauche', 'actif'];

    protected $validationRules = [
        'nom' => 'required|string|max_length[255]',
        'email' => 'required|valid_email|is_unique[Employes.email]',
        'mot_de_passe' => 'required|string|min_length[6]',
        'role' => 'required|in_list[employe,manager]',
        'departement' => 'required|string|max_length[255]',
        'date_embauche' => 'required|valid_date',
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Cet email est déjà utilisé.',
        ],
    ];

    protected $skipValidation = false;

    
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeModel extends Model{
    protected $table = 'Employes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'email', 'mot_de_passe', 'role', 'departement', 'date_embauche', 'actif'];
    
}
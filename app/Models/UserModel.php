<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model{

    protected $table = 'utilisateurs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'genre' ,'email', 'mot_de_passe', 'role', 'est_gold', 'solde_portefeuille'];
    protected $useTimestamps = false;

    protected $validationRules = [
        'nom' => 'required[min_length[3]]',
        'email' => 'required[required|valid_email]',
        'mot_de_passe' => 'required[min_length[6]]',
        'role' => 'required|in_list[user,admin]',
    ];

    public function getUserByEmail($email){
        return $this->where('email', $email)->first();
    }

    public function createUser($data){

        return $this->insert($data);
    }

    public function updateUser($id, $data){
        return $this->update($id, $data);
    }
    
    public function countUser(){
        return $this->where('role !=', 'admin')->countAllResults();
    }
    
}
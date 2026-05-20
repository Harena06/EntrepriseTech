<?php

    namespace App\Controllers;
    use App\Models\UserModel;
    use App\Models\CongeModel;

    class EmployeController extends BaseController
    {
        public function index()
        {  
            
            $congeModel = new CongeModel();
            $employeId = session()->get('user')['id'] ?? null;
            $conge = $congeModel->getCongesByEmploye($employeId);
            return view('Modal', [
            'page' => 'employe/Index', 
            'conges' => $conge,
            'active' => 'index',
            'user' => session()->get('user')
            ]);
        }
    }
<?php

    namespace App\Controllers;
    use App\Models\UserModel;
    use App\Models\CongeModel;
    use App\Models\TypeCongeModel;
    use App\Models\SoldeModel;

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

        public function dashboard()
        {   
            $user = session()->get('user');
            $CongeEnAttente = new CongeModel();
            $typesConge = new TypeCongeModel();
            $SoldeModel = new SoldeModel();
            $nbJoursPris = [];
            // foreach ($typesConge->findAll() as $type) {
            //     $annee = $SoldeModel->getAnneeSolde($user['id'], $type['id']);
            //     $nbJoursPris[$type['id']] = $SoldeModel->hasSoldeDisponible($user['id'] , $type['id'], $annee, 0);
            // }
            $typesConge = $typesConge->findAll();
            $employeId = session()->get('user')['id'] ?? null;
            $congeEnAttente = $CongeEnAttente->getCongesEnAttenteByEmploye($employeId);
            $congeApprouve = $CongeEnAttente->getCongesApprouvesByEmploye($employeId);
            $congerefuse = $CongeEnAttente->getCongesRefusesByEmploye($employeId);
            $congeLimited = $CongeEnAttente->getCongesByEmployeLimited($employeId, 3);

            return view('Modal', [
                'page' => 'employe/Dashboard',
                'active' => 'dashboard',
                'user' => session()->get('user'),
                'congesEnAttente' => $congeEnAttente,
                'congesApprouve' => $congeApprouve,
                'congesRefuse' => $congerefuse  ,
                'congesLimited' => $congeLimited,
                'typesConge' => $typesConge,
                'nbJoursPris' => $nbJoursPris
            ]);
        }
    }
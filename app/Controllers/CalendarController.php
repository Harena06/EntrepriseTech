<?php

namespace App\Controllers;

use App\Models\CongeModel;
use App\Models\TypeCongeModel;
use App\Models\EmployeModel;
class CalendarController extends BaseController {
    public function index()
    {   
        $user = session()->get('user');
        if (! $user) {
            return redirect()->to('/');
        }

        $congeModel = new CongeModel();
        $conges = $congeModel->getCongesByEmploye((int) $user['id']);

        return view('Modal', [
            'page' => 'employe/Calendar',
            'user' => $user,
            'active' => 'calendar',
            'conges' => $conges
        ]);
    }
}
<?php

    namespace App\Controllers;
    use App\Models\UserModel;

    class EmployeController extends BaseController
    {
        public function index()
        {
            return view('Model', ['page' => 'employe/Index']);
        }
    }
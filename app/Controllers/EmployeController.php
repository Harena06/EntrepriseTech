<?php

    namespace App\Controllers;
    use App\Models\UserModel;

    class EmployeController extends BaseController
    {
        public function index()
        {
            return view('Modal', ['page' => 'employe/Index']);
        }
    }
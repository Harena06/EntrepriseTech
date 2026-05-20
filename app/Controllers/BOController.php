<?php

namespace App\Controllers;

class BOController extends BaseController
{
    public function general()
    {
        return view('Modal', ['page' => 'admin/employes']);
    }
}

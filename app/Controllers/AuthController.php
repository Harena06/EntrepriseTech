<?php

namespace App\Controllers;

use App\Models\EmployeModel;

class AuthController extends BaseController
{
    public function form()
    {
        return view('Modal', ['page' => 'auth/Login']);
    }

    public function login()
    {
        $model = new EmployeModel();

        $role = strtolower((string) $this->request->getPost('role'));
        $email = (string) $this->request->getPost('email');
        $password = (string) $this->request->getPost('password');

        $user = $model->getEmployeByEmail($email);
        if (! $user) {
            return view('Modal', [
                'erreur' => 'Email ou mot de passe incorrect',
                'page'   => 'auth/Login',
            ]);
        }

        if (isset($user['actif']) && (int) $user['actif'] === 0) {
            return view('Modal', [
                'erreur' => 'Compte désactivé',
                'page'   => 'auth/Login',
            ]);
        }

        if (! isset($user['mot_de_passe']) || $user['mot_de_passe'] !== $password) {
            return view('Modal', [
                'erreur' => 'Email ou mot de passe incorrect',
                'page'   => 'auth/Login',
            ]);
        }

        $dbRole = strtolower((string) ($user['role'] ?? ''));
        if ($role !== '' && $dbRole !== '' && $dbRole !== $role) {
            return view('Modal', [
                'erreur' => 'Rôle sélectionné ne correspond pas à l\'utilisateur',
                'page'   => 'auth/Login',
            ]);
        }

        if ($dbRole === 'admin') {
            session()->set('admin', [
                'id'    => $user['id'],
                'nom'   => $user['nom'],
                'email' => $user['email'],
                'role'  => $user['role'],
            ]);

            return redirect()->to('/bo/dashboard/general');
        }

        if ($dbRole === 'rh') {
            session()->set('rh', [
                'id'    => $user['id'],
                'nom'   => $user['nom'],
                'email' => $user['email'],
                'role'  => $user['role'],
            ]);

            return redirect()->to('/rh/dashboard/general');
        }

        session()->set('user', [
            'id'    => $user['id'],
            'nom'   => $user['nom'],
            'email' => $user['email'],
            'role'  => $user['role'],
        ]);

        return redirect()->to('/index');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/');
    }
}
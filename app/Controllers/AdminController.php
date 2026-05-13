<?php

namespace App\Controllers;

use App\Models\DepartementModel;
use App\Models\TypeCongeModel;
use App\Models\EmployeModel;

class AdminController extends BaseController
{
    public function employes()
    {
        $admin = session()->get('admin');
        if (! $admin) {
            return redirect()->to('/');
        }

        $model = new EmployeModel();

        return $this->response->setJSON($model->findAll());
    }

    public function updateEmploye($id)
    {
        $admin = session()->get('admin');
        if (! $admin) {
            return redirect()->to('/');
        }

        $model = new EmployeModel();

        $data = array_filter([
            'nom' => $this->request->getPost('nom'),
            'email' => $this->request->getPost('email'),
            'role' => $this->request->getPost('role'),
            'departement_id' => $this->request->getPost('departement_id'),
            'actif' => $this->request->getPost('actif'),
        ], static fn ($v) => $v !== null && $v !== '');

        if (! $model->update((int) $id, $data)) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Mise a jour impossible',
                'details' => $model->errors(),
            ]);
        }

        return $this->response->setJSON(['success' => true]);
    }

    public function departements()
    {
        $admin = session()->get('admin');
        if (! $admin) {
            return redirect()->to('/');
        }

        $model = new DepartementModel();

        return $this->response->setJSON($model->findAll());
    }

    public function createDepartement()
    {
        $admin = session()->get('admin');
        if (! $admin) {
            return redirect()->to('/');
        }

        $model = new DepartementModel();

        $data = [
            'nom' => (string) $this->request->getPost('nom'),
            'description' => (string) $this->request->getPost('description'),
        ];

        if (! $model->insert($data)) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Creation impossible',
                'details' => $model->errors(),
            ]);
        }

        return $this->response->setJSON(['success' => true]);
    }

    public function updateDepartement($id)
    {
        $admin = session()->get('admin');
        if (! $admin) {
            return redirect()->to('/');
        }

        $model = new DepartementModel();

        $data = array_filter([
            'nom' => $this->request->getPost('nom'),
            'description' => $this->request->getPost('description'),
        ], static fn ($v) => $v !== null && $v !== '');

        if (! $model->update((int) $id, $data)) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Mise a jour impossible',
                'details' => $model->errors(),
            ]);
        }

        return $this->response->setJSON(['success' => true]);
    }

    public function deleteDepartement($id)
    {
        $admin = session()->get('admin');
        if (! $admin) {
            return redirect()->to('/');
        }

        $model = new DepartementModel();

        return $this->response->setJSON([
            'success' => (bool) $model->delete((int) $id),
        ]);
    }

    public function typesConges()
    {
        $admin = session()->get('admin');
        if (! $admin) {
            return redirect()->to('/');
        }

        $model = new TypeCongeModel();

        return $this->response->setJSON($model->findAll());
    }

    public function createTypeConge()
    {
        $admin = session()->get('admin');
        if (! $admin) {
            return redirect()->to('/');
        }

        $model = new TypeCongeModel();

        $data = [
            'libelle' => (string) $this->request->getPost('libelle'),
            'jours_annuels' => (int) $this->request->getPost('jours_annuels'),
            'deductible' => (int) $this->request->getPost('deductible'),
        ];

        if (! $model->insert($data)) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Creation impossible',
                'details' => $model->errors(),
            ]);
        }

        return $this->response->setJSON(['success' => true]);
    }

    public function updateTypeConge($id)
    {
        $admin = session()->get('admin');
        if (! $admin) {
            return redirect()->to('/');
        }

        $model = new TypeCongeModel();

        $data = array_filter([
            'libelle' => $this->request->getPost('libelle'),
            'jours_annuels' => $this->request->getPost('jours_annuels'),
            'deductible' => $this->request->getPost('deductible'),
        ], static fn ($v) => $v !== null && $v !== '');

        if (! $model->update((int) $id, $data)) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Mise a jour impossible',
                'details' => $model->errors(),
            ]);
        }

        return $this->response->setJSON(['success' => true]);
    }

    public function deleteTypeConge($id)
    {
        $admin = session()->get('admin');
        if (! $admin) {
            return redirect()->to('/');
        }

        $model = new TypeCongeModel();

        return $this->response->setJSON([
            'success' => (bool) $model->delete((int) $id),
        ]);
    }
}

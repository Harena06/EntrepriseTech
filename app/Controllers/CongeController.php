<?php

namespace App\Controllers;

use App\Models\CongeModel;

class CongeController extends BaseController
{
    public function mesDemandes()
    {
        $user = session()->get('user');
        if (! $user) {
            return redirect()->to('/');
        }

        $model = new CongeModel();
        $conges = $model->getCongesByEmploye((int) $user['id']);

        return $this->response->setJSON($conges);
    }

    public function demander()
    {
        $user = session()->get('user');
        if (! $user) {
            return redirect()->to('/');
        }

        $model = new CongeModel();

        $data = [
            'employe_id' => (int) $user['id'],
            'type_conge_id' => (int) $this->request->getPost('type_conge_id'),
            'date_debut' => (string) $this->request->getPost('date_debut'),
            'date_fin' => (string) $this->request->getPost('date_fin'),
            'nb_jours' => (int) $this->request->getPost('nb_jours'),
            'motif' => (string) $this->request->getPost('motif'),
            'statut' => 'en_attente',
            'commentaire_rh' => null,
            'traite_par' => null,
        ];

        if (! $model->insert($data)) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Demande invalide',
                'details' => $model->errors(),
            ]);
        }

        return $this->response->setJSON(['success' => true]);
    }

    public function annuler($id)
    {
        $user = session()->get('user');
        if (! $user) {
            return redirect()->to('/');
        }

        $model = new CongeModel();
        $conge = $model->find((int) $id);
        if (! $conge || (int) $conge['employe_id'] !== (int) $user['id']) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Demande introuvable']);
        }

        $annee = (int) $this->request->getPost('annee');
        if (! $annee) {
            $annee = (int) date('Y');
        }

        if (! $model->annulerConge((int) $id, $annee)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Annulation impossible']);
        }

        return $this->response->setJSON(['success' => true]);
    }
}

<?php

namespace App\Controllers;

use App\Models\CongeModel;
use App\Models\TypeCongeModel;
use App\Models\EmployeModel;
class CongeController extends BaseController
{
    public function formulaireDemande()
    {   
        $typeCongeModel = new TypeCongeModel();
        $typesConge = $typeCongeModel->findAll();
        $user = session()->get('user');
        if (! $user) {
            return redirect()->to('/');
        }

        return view('Modal', [
            'page' => 'employe/Create',
            'user' => $user,
            'typesConge' => $typesConge,
            'active' => 'create'
        ]);
    }
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

        $payload = $this->request->getPost();
        if (empty($payload)) {
            $payload = (array) $this->request->getJSON(true);
        }

        if (empty($payload)) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Aucune donnee recue.',
            ]);
        }

        $data = [
            'employe_id' => (int) $user['id'],
            'type_conge_id' => (int) ($payload['type_conge_id'] ?? 0),
            'date_debut' => (string) ($payload['date_debut'] ?? ''),
            'date_fin' => (string) ($payload['date_fin'] ?? ''),
            'nb_jours' => (int) ($payload['nb_jours'] ?? 0),
            'motif' => trim((string) ($payload['motif'] ?? '')),
            'statut' => 'en_attente',
            'commentaire_rh' => null,
            'traite_par' => null,
        ];

        if ($data['nb_jours'] <= 0 && $data['date_debut'] !== '' && $data['date_fin'] !== '') {
            try {
                $start = new \DateTime($data['date_debut']);
                $end = new \DateTime($data['date_fin']);
                $data['nb_jours'] = (int) $start->diff($end)->days;
            } catch (\Exception $e) {
                return $this->response->setStatusCode(400)->setJSON([
                    'error' => 'Dates invalides',
                ]);
            }
        }

        if ($data['type_conge_id'] <= 0 || $data['date_debut'] === '' || $data['date_fin'] === '' || $data['nb_jours'] <= 0) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Champs obligatoires manquants.',
            ]);
        }

        if (! $model->db->table('Conges')->insert($data)) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Demande invalide',
                'details' => $model->db->error(),
            ]);
        }

        return redirect()->to('/nouvelle-Demande')->with('success', 'Demande de congé soumise avec succès.');
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

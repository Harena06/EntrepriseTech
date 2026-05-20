<?php

namespace App\Controllers;

use App\Models\CongeModel;

class RHController extends BaseController
{
    public function general()
    {
        return view('Modal', ['page' => 'rh/index']);
    }

    public function demandesEnAttente()
    {
        $rh = session()->get('rh') ?? session()->get('admin');
        if (! $rh) {
            return redirect()->to('/');
        }

        $model = new CongeModel();

        return $this->response->setJSON($model->getCongesEnAttente());
    }

    public function approuver($id)
    {
        $rh = session()->get('rh') ?? session()->get('admin');
        if (! $rh) {
            return redirect()->to('/');
        }

        $annee = (int) $this->request->getPost('annee');
        if (! $annee) {
            $annee = (int) date('Y');
        }

        $commentaire = (string) $this->request->getPost('commentaire');

        $model = new CongeModel();
        if (! $model->approuverConge((int) $id, (int) $rh['id'], $annee, $commentaire)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Approbation impossible']);
        }

        return $this->response->setJSON(['success' => true]);
    }

    public function refuser($id)
    {
        $rh = session()->get('rh') ?? session()->get('admin');
        if (! $rh) {
            return redirect()->to('/');
        }

        $commentaire = (string) $this->request->getPost('commentaire');

        $model = new CongeModel();
        if (! $model->refuserConge((int) $id, (int) $rh['id'], $commentaire)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Refus impossible']);
        }

        return $this->response->setJSON(['success' => true]);
    }

    public function filtrer()
    {
        $rh = session()->get('rh') ?? session()->get('admin');
        if (! $rh) {
            return redirect()->to('/');
        }

        $departementId = $this->request->getGet('departement_id');
        $statut = $this->request->getGet('statut');

        $builder = db_connect()->table('Conges c')
            ->select('c.*')
            ->join('Employes e', 'e.id = c.employe_id');

        if ($departementId !== null && $departementId !== '') {
            $builder->where('e.departement_id', (int) $departementId);
        }

        if ($statut) {
            $builder->where('c.statut', $statut);
        }

        $result = $builder->orderBy('c.id', 'DESC')->get()->getResultArray();

        return $this->response->setJSON($result);
    }
}

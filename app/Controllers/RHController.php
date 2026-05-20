<?php

namespace App\Controllers;

use App\Models\CongeModel;

class RHController extends BaseController
{
    public function general()
    {
        $rh = session()->get('rh') ?? session()->get('admin');
        if (! $rh) {
            return redirect()->to('/');
        }

        $model = new CongeModel();
        $conges = $model->getCongesEnAttente();
        $congesapprouver = $model->getCongesApprouver();
        return view('Modal', ['page' => 'rh/index', 'conges' => $conges, 'congesapprouver' => $congesapprouver]);
    }

    public function approuver($id)
    {
        try {
            $rh = session()->get('rh') ?? session()->get('admin');
            if (! $rh) {
                return $this->response->setStatusCode(401)->setJSON(['error' => 'Non authentifié']);
            }

            $annee = (int) $this->request->getPost('annee');
            if (! $annee) {
                $annee = (int) date('Y');
            }

            $commentaire = (string) $this->request->getPost('commentaire');

            $model = new CongeModel();
            $approuverConge = $model->approuverConge((int) $id, (int) $rh['id'], $annee, $commentaire);
            
            if (! $approuverConge) {
                return $this->response->setStatusCode(400)->setJSON(['error' => 'Approbation impossible']);
            }
            
            return $this->response->setJSON(['success' => true]);
        } catch (\Exception $e) {
            log_message('error', 'RHController::approuver - ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['error' => $e->getMessage()]);
        }
    }

    public function refuser($id)
    {
        try {
            $rh = session()->get('rh') ?? session()->get('admin');
            if (! $rh) {
                return $this->response->setStatusCode(401)->setJSON(['error' => 'Non authentifié']);
            }

            $commentaire = (string) $this->request->getPost('commentaire');

            $model = new CongeModel();
            $refuserConge = $model->refuserConge((int) $id, (int) $rh['id'], $commentaire);
            
            if (! $refuserConge) {
                return $this->response->setStatusCode(400)->setJSON(['error' => 'Refus impossible']);
            }
            
            return $this->response->setJSON(['success' => true]);
        } catch (\Exception $e) {
            log_message('error', 'RHController::refuser - ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['error' => $e->getMessage()]);
        }
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

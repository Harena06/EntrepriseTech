<?php

namespace App\Controllers;

use App\Models\SoldeModel;

class SoldeController extends BaseController
{
    public function mesSoldes()
    {
        $user = session()->get('user');
        if (! $user) {
            return redirect()->to('/');
        }

        $annee = (int) $this->request->getGet('annee');
        if (! $annee) {
            $annee = (int) date('Y');
        }

        $builder = db_connect()->table('Soldes s')
            ->select('s.*, t.libelle')
            ->join('Types_conges t', 't.id = s.type_conge_id')
            ->where('s.employe_id', (int) $user['id'])
            ->where('s.annee', $annee);

        $rows = $builder->get()->getResultArray();

        foreach ($rows as &$row) {
            $row['jours_restants'] = (int) $row['jours_attribues'] - (int) $row['jours_pris'];
        }
        unset($row);

        return $this->response->setJSON($rows);
    }

    public function soldeEmploye($id)
    {
        $rh = session()->get('rh') ?? session()->get('admin');
        if (! $rh) {
            return redirect()->to('/');
        }

        $annee = (int) $this->request->getGet('annee');
        if (! $annee) {
            $annee = (int) date('Y');
        }

        $builder = db_connect()->table('Soldes s')
            ->select('s.*, t.libelle')
            ->join('Types_conges t', 't.id = s.type_conge_id')
            ->where('s.employe_id', (int) $id)
            ->where('s.annee', $annee);

        $rows = $builder->get()->getResultArray();

        foreach ($rows as &$row) {
            $row['jours_restants'] = (int) $row['jours_attribues'] - (int) $row['jours_pris'];
        }
        unset($row);

        return $this->response->setJSON($rows);
    }
}

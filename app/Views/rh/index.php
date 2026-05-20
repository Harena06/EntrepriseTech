<section id="page-liste-rh" style="margin-top:3rem" data-approve-url="<?php echo site_url('/rh/conges/approuver'); ?>" data-refuse-url="<?php echo site_url('/rh/conges/refuser'); ?>">
<div class="app-wrap">

  <aside class="sidebar">
    <div class="sidebar-brand">
      <div class="sidebar-logo-icon"><i class="bi bi-person-check"></i></div>
      <div class="sidebar-brand-name">TechMada RH<span>Espace responsable</span></div>
    </div>
    <div class="sidebar-section">Menu</div>
    <ul class="sidebar-nav">
      <li><a href="#page-dashboard-rh"><i class="bi bi-grid-1x2"></i> Tableau de bord</a></li>
      <li>
        <a href="#page-liste-rh" class="active">
          <i class="bi bi-inbox"></i> Demandes à traiter
          <span class="nav-badge alert"><?php echo count($conges); ?></span>
        </a>
      </li>
      <li><a href="#page-liste-rh"><i class="bi bi-archive"></i> Historique</a></li>
      <li><a href="#page-liste-rh"><i class="bi bi-people"></i> Soldes employés</a></li>
    </ul>
    <div class="sidebar-user">
      <div class="s-user-row">
        <div class="avatar av-blue">MR</div>
        <div><div class="user-name"><?php echo session()->get('rh')['nom']?></div><div class="user-role">Responsable RH</div></div>
        <a href="#page-login" style="margin-left:auto;color:rgba(255,255,255,.25);font-size:1.1rem"><i class="bi bi-box-arrow-right"></i></a>
      </div>
    </div>
  </aside>

  <div class="main">
    <div class="topbar">
      <div>
        <div class="topbar-title">Demandes à traiter</div>
        <div class="topbar-breadcrumb"><a href="#page-dashboard-rh">Accueil</a> <i class="bi bi-chevron-right" style="font-size:.6rem"></i> Demandes</div>
      </div>
      <div class="topbar-actions">
        <span style="font-size:.8rem;color:var(--muted);background:var(--warn-bg);border:1px solid var(--warn-br);border-radius:6px;padding:5px 10px;display:flex;align-items:center;gap:5px;color:var(--warn)">
          <i class="bi bi-hourglass-split"></i> <?php echo count($conges); ?> en attente
        </span>
      </div>
    </div>

    <div class="content">

      <!-- Flash -->
      <div class="flash flash-success">
        <i class="bi bi-check-circle-fill"></i>
        Demande de Soa Rakoto approuvée. Son solde a été mis à jour automatiquement.
      </div>

      <!-- Filtre -->
      <div style="display:flex;gap:8px;margin-bottom:1.25rem;flex-wrap:wrap">
        <button style="padding:6px 14px;border-radius:20px;font-size:.8rem;font-weight:500;border:1.5px solid var(--forest);background:var(--forest);color:var(--white);cursor:pointer">Tous (8)</button>
        <button style="padding:6px 14px;border-radius:20px;font-size:.8rem;font-weight:500;border:1.5px solid var(--border);background:var(--white);color:var(--muted);cursor:pointer">En attente (4)</button>
        <button style="padding:6px 14px;border-radius:20px;font-size:.8rem;font-weight:500;border:1.5px solid var(--border);background:var(--white);color:var(--muted);cursor:pointer">Approuvées (3)</button>
        <button style="padding:6px 14px;border-radius:20px;font-size:.8rem;font-weight:500;border:1.5px solid var(--border);background:var(--white);color:var(--muted);cursor:pointer">Refusées (1)</button>
        <select class="f-select" style="font-size:.8rem;padding:6px 10px;width:auto;margin-left:auto">
          <option>Tous les départements</option>
          <option>IT</option>
          <option>Finance</option>
          <option>Marketing</option>
        </select>
      </div>

      <div class="data-card">
        <div class="data-card-head"><h3>Toutes les demandes</h3></div>
        <table class="tbl">
          <thead>
            <tr><th>Employé</th><th>Type</th><th>Période</th><th>Durée</th><th>Solde dispo</th><th>Statut</th><th>Actions</th></tr>
          </thead>
          <tbody>
            <!-- En attente — actions disponibles -->

              <?php foreach ($conges as $conge): ?>
                <tr>
                  <td>
                    <div class="profile-row">
                      <div class="avatar av-green" style="width:32px;height:32px;font-size:.7rem"><?php echo esc((string) ($conge['employe_nom'])); ?></div>
                      <div class="profile-info">
                        <div class="pname"><?php echo esc($conge['employe_nom']); ?></div>
                        <div class="pdept"><?php echo esc($conge['employe_departement']); ?></div>
                      </div>
                    </div>
                  </td>
                  <td><span class="type-badge t-annuel"><?php echo esc($conge['type_conge_nom']); ?></span></td>
                  <td class="td-muted" style="font-size:.8rem"><?php echo esc($conge['date_debut']); ?> - <?php echo esc($conge['date_fin']); ?></td>
                  <td class="td-mono"><?php echo esc($conge['nb_jours']); ?> j</td>
                  <td>
                    <span style="font-family:'DM Mono',monospace;font-size:.82rem;color:var(--success);font-weight:500"><?php echo esc((int)$conge['solde_restant']); ?></span>
                    <span style="font-size:.72rem;color:var(--muted)"> dispo</span>
                  </td>
                  <td><span class="statut s-attente"><?php echo esc($conge['statut']); ?></span></td>
                  <td>
                    <div class="action-btns">
                      <button type="button" class="btn-sm btn-approve js-approve" data-conge-id="<?php echo esc((string) $conge['id']); ?>"><i class="bi bi-check-lg"></i> Approuver</button>
                      <button type="button" class="btn-sm btn-refuse js-refuse" data-conge-id="<?php echo esc((string) $conge['id']); ?>" data-employe-nom="<?php echo esc($conge['employe_nom']); ?>" data-type-conge="<?php echo esc($conge['type_conge_nom']); ?>" data-date-debut="<?php echo esc($conge['date_debut']); ?>" data-date-fin="<?php echo esc($conge['date_fin']); ?>" data-nb-jours="<?php echo esc((string) $conge['nb_jours']); ?>"><i class="bi bi-x-lg"></i> Refuser</button>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
              
              <?php foreach ($congesapprouver as $conge): ?>
                 <tr>
              <td>
                <div class="profile-row">
                  <div class="avatar av-green" style="width:32px;height:32px;font-size:.7rem"><?php echo esc((string) ($conge['employe_nom'])); ?></div>
                  <div class="profile-info">
                  <div class="profile-info"><div class="pname"><?php echo esc($conge['employe_nom']); ?></div>
                  <div class="pdept"><?php echo esc($conge['employe_departement']); ?></div></div>
                </div>
              </td>
              <td><span class="type-badge t-maladie"><?php echo esc($conge['type_conge_nom']); ?></span></td>
              <td class="td-muted" style="font-size:.8rem"><?php echo esc($conge['date_debut']); ?> - <?php echo esc($conge['date_fin']); ?></td>
              <td class="td-mono"><?php echo esc($conge['nb_jours']); ?> j</td>
              <td><span style="font-family:'DM Mono',monospace;font-size:.82rem;color:var(--muted)"><?php echo esc((int) $conge['solde_restant']); ?></span></td>
              <td><span class="statut s-approuvee"><?php echo esc($conge['statut']); ?></span></td>
              <td><span class="td-muted" style="font-size:.75rem"><?php echo esc($conge['rh_nom'] ?? '-'); ?></span></td>
            </tr>
              <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- Modal refus (dynamique) -->
      <div id="refus-panel" style="margin-top:1.5rem;display:none">
        <div class="form-section" style="border-color:var(--danger-br);background:var(--danger-bg)">
          <h3 style="color:var(--danger)"><i class="bi bi-x-circle"></i> Confirmer le refus — <span id="refus-employe-nom"></span></h3>
          <div style="font-size:.875rem;color:var(--ink);margin-bottom:1rem">
            Demande de <strong id="refus-nb-jours"></strong> jours <span id="refus-periode"></span> · Type : <span id="refus-type-conge"></span><br>
            <span style="font-size:.8rem;color:var(--danger)" id="refus-solde-info"></span>
          </div>
          <div class="f-group">
            <label class="f-label">Commentaire pour l'employé (optionnel)</label>
            <textarea id="refus-commentaire" class="f-textarea" placeholder="Ex : Solde insuffisant, veuillez contacter les RH pour un congé sans solde."></textarea>
          </div>
          <div class="form-actions">
            <button id="refus-confirm" type="button" class="btn-sm btn-refuse" style="padding:9px 16px;font-size:.875rem"><i class="bi bi-x-lg"></i> Confirmer le refus</button>
            <button id="refus-cancel" type="button" class="btn-secondary"><i class="bi bi-arrow-left"></i> Annuler</button>
          </div>
        </div>
      </div>

    </div>
    <div class="footer-app"><i class="bi bi-c-circle"></i> 2025 <span>TechMada RH</span></div>
       
      <?php ?>
      <!-- <div style="margin-top:1.5rem">
        <div class="form-section" style="border-color:var(--danger-br);background:var(--danger-bg)">
          <h3 style="color:var(--danger)"><i class="bi bi-x-circle"></i> Confirmer le refus — Tsiry Fidy</h3>
          <div style="font-size:.875rem;color:var(--ink);margin-bottom:1rem">
            Demande de <strong>2 jours</strong> du 18 au 19 juin 2025 · Type : Maladie<br>
            <span style="font-size:.8rem;color:var(--danger)"><i class="bi bi-exclamation-triangle"></i> Solde insuffisant : 1 jour disponible, 2 demandés.</span>
          </div>
          <div class="f-group">
            <label class="f-label">Commentaire pour l'employé (optionnel)</label>
            <textarea class="f-textarea" placeholder="Ex : Solde insuffisant, veuillez contacter les RH pour un congé sans solde.">Solde insuffisant. Solde maladie restant : 1 jour.</textarea>
          </div>
          <div class="form-actions">
            <button class="btn-sm btn-refuse" style="padding:9px 16px;font-size:.875rem"><i class="bi bi-x-lg"></i> Confirmer le refus</button>
            <button class="btn-secondary"><i class="bi bi-arrow-left"></i> Annuler</button>
          </div>
        </div>
      </div>

    </div>
    <div class="footer-app"><i class="bi bi-c-circle"></i> 2025 <span>TechMada RH</span></div> -->
  </div>
</div>
</section>
<script src="/assets/js/rh.js"></script>
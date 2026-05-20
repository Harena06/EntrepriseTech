(function () {
  const root = document.getElementById('page-liste-rh');
  if (!root) {
    return;
  }

  const approveBaseUrl = root.dataset.approveUrl;
  const refuseBaseUrl = root.dataset.refuseUrl;
  const refusPanel = document.getElementById('refus-panel');
  const refusEmployeNom = document.getElementById('refus-employe-nom');
  const refusNbJours = document.getElementById('refus-nb-jours');
  const refusPeriode = document.getElementById('refus-periode');
  const refusTypeConge = document.getElementById('refus-type-conge');
  const refusSoldeInfo = document.getElementById('refus-solde-info');
  const refusCommentaire = document.getElementById('refus-commentaire');
  const refusConfirmBtn = document.getElementById('refus-confirm');
  const refusCancelBtn = document.getElementById('refus-cancel');
  let selectedRefusId = null;

  async function postAction(url, payload) {
    try {
      const response = await fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: new URLSearchParams(payload),
      });

      console.log('Response Status:', response.status);
      console.log('Response Headers:', response.headers);
      
      const text = await response.text();
      console.log('Response Text:', text);

      let data = {};
      try {
        data = JSON.parse(text);
      } catch (e) {
        console.error('JSON Parse Error:', e);
      }
      
      console.log('Data:', data);

      if (!response.ok || data.success !== true) {
        throw new Error(data.error || `Erreur serveur (${response.status})`);
      }

      return data;
    } catch (error) {
      console.error('PostAction Error:', error);
      throw error;
    }
  }

  document.querySelectorAll('.js-approve').forEach((button) => {
    button.addEventListener('click', async () => {
      const congeId = button.dataset.congeId;
      if (!congeId || !window.confirm('Approuver cette demande ?')) {
        return;
      }

      button.disabled = true;
      try {
        await postAction(`${approveBaseUrl}/${congeId}`, {
          annee: new Date().getFullYear(),
          commentaire: '',
        });
        window.location.reload();
      } catch (error) {
        window.alert(error.message);
        button.disabled = false;
      }
    });
  });

  document.querySelectorAll('.js-refuse').forEach((button) => {
    button.addEventListener('click', () => {
      selectedRefusId = button.dataset.congeId || null;
      const employeNom = button.dataset.employeNom || '-';
      const nbJours = button.dataset.nbJours || '0';
      const dateDebut = button.dataset.dateDebut || '';
      const dateFin = button.dataset.dateFin || '';
      const typeConge = button.dataset.typeConge || '-';

      refusEmployeNom.textContent = employeNom;
      refusNbJours.textContent = nbJours;
      refusPeriode.textContent = `du ${dateDebut} au ${dateFin}`;
      refusTypeConge.textContent = typeConge;
      refusSoldeInfo.innerHTML = '<i class="bi bi-exclamation-triangle"></i> Vérifie le commentaire avant validation.';
      
      refusCommentaire.value = '';
      refusPanel.style.display = 'block';
      refusPanel.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
  });

  refusCancelBtn.addEventListener('click', () => {
    selectedRefusId = null;
    refusPanel.style.display = 'none';
    refusCommentaire.value = '';
  });

  refusConfirmBtn.addEventListener('click', async () => {
    if (!selectedRefusId) {
      return;
    }

    refusConfirmBtn.disabled = true;
    try {
      await postAction(`${refuseBaseUrl}/${selectedRefusId}`, {
        commentaire: refusCommentaire.value,
      });
      window.location.reload();
    } catch (error) {
      window.alert(error.message);
      refusConfirmBtn.disabled = false;
    }
  });
})();

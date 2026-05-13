<?php /** @var string|null $erreur */ ?>

<main style="max-width: 520px; margin: 48px auto; padding: 24px;">
	<h2>Connexion</h2>

	<?php if (isset($erreur) && $erreur): ?>
		<div style="margin: 12px 0; padding: 10px; border: 1px solid #f0a;">
			<?= esc($erreur) ?>
		</div>
	<?php endif; ?>

	<form method="post" action="<?= site_url('/login') ?>" autocomplete="off">
		<?= function_exists('csrf_field') ? csrf_field() : '' ?>

		<div style="margin-bottom: 12px;">
			<label for="role">Rôle</label>
			<select id="role" name="role" required>
				<option value="employe">Employé</option>
				<option value="rh">Responsable RH</option>
				<option value="admin">Administrateur</option>
			</select>
		</div>

		<div style="margin-bottom: 12px;">
			<label for="email">Email</label>
			<input id="email" name="email" type="email" required />
		</div>

		<div style="margin-bottom: 12px;">
			<label for="password">Mot de passe</label>
			<input id="password" name="password" type="password" required />
		</div>

		<button type="submit">Se connecter</button>
	</form>
</main>

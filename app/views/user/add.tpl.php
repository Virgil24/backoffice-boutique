<div class="container my-4">
    <a href="<?= $router->generate('user-list'); ?>" class="btn btn-success float-right">Retour</a>
    <h2>Ajouter un utilisateur</h2>

    <?php include __DIR__ . '/../partials/errorlist.tpl.php'; ?>

    <form action="" method="POST" class="mt-5">

        <div class="form-group">
            <label for="firstname">Prénom</label>
            <input
                type="text"
                class="form-control"
                id="firstname" name="firstname"
                placeholder="Prénom de l'utilisateur"
                value="<?= isset($errorUser) ? $errorUser->getFirstname() : ''; ?>">
        </div>

        <div class="form-group">
            <label for="lastname">Nom</label>
            <input
                type="text"
                class="form-control"
                id="lastname" name="lastname"
                placeholder="Nom de l'utilisateur"
                value="<?= isset($errorUser) ? $errorUser->getLastname() : ''; ?>">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input
                type="email"
                class="form-control"
                id="email" name="email"
                placeholder="Email de l'utilisateur"
                value="<?= isset($errorUser) ? $errorUser->getEmail() : ''; ?>">
        </div>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input
                type="password"
                class="form-control"
                id="password" name="password"
                placeholder="Mot de passe de l'utilisateur">
        </div>

        <div class="form-group">
            <label for="conf_password">Confirmation du mot de passe</label>
            <input
                type="password"
                class="form-control"
                id="conf_password" name="conf_password"
                placeholder="Confirmation du mot de passe de l'utilisateur">
        </div>

        <div class="form-group">
            <label for="role">Rôle de l'utilisateur</label>
            <select id="role" name="role" class="form-control">
                <option
                    disabled
                    <?= !isset($errorUser) ? 'selected' : ''; ?>>
                        Merci de selectionner un rôle
                </option>
                <option
                    value="admin"
                    <?= isset($errorUser) && $errorUser->getRole() == 'admin' ? 'selected' : ''; ?>>
                        Rôle Administrateur
                </option>
                <option
                    value="catalog-manager"
                    <?= isset($errorUser) && $errorUser->getRole() == 'catalog-manager' ? 'selected' : ''; ?>>
                        Rôle catalogue manager
                </option>
            </select>
        </div>

        <div class="form-group">
            <label for="status">Status de l'utilisateur</label>
            <select id="status" name="status" class="form-control">
                <option
                    disabled
                    <?= !isset($errorUser) ? 'selected' : ''; ?>>
                        Merci de selectionner un status
                </option>
                <option
                    value="1"
                    <?= isset($errorUser) && $errorUser->getStatus() == '1' ? 'selected' : ''; ?>>
                        Actif
                </option>
                <option
                    value="2"
                    <?= isset($errorUser) && $errorUser->getStatus() == '2' ? 'selected' : ''; ?>>
                        Bloqué
                </option>
            </select>
        </div>
        <input type="hidden" name="token" value="<?=$token?>">
        <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
    </form>
</div>
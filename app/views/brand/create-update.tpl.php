<div class="container my-4">
        <a href="<?= $router->generate('brand-list') ?>" class="btn btn-success float-right">Retour</a>
        <h2><?= (isset($mode) && $mode === 'create') ? 'Ajouter' : 'Modifier'?> une marque</h2>
        <?php include __DIR__.'/../partials/errorlist.tpl.php'?>
        <form action="" method="POST" class="mt-5">
            <div class="form-group">
                <label for="name">Nom</label>
                <input 
                    type="text" 
                    class="form-control" 
                    name="name"
                    id="name" 
                    placeholder="Nom de la catégorie" 
                    value= "<?= (isset($brand)? $brand->getName(): '');?>">
            </div>
            <input type="hidden" name="token" value="<?=$token?>">
            <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
        </form>
    </div>
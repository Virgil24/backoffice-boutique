<div class="container my-4">
        <a href="<?= $router->generate('category-list') ?>" class="btn btn-success float-right">Retour</a>
        <h2><?= (isset($mode) && $mode === 'create') ? 'Ajouter' : 'Modifier'?> une catégorie</h2>
        <?php include __DIR__.'/../partials/errorlist.tpl.php'?>
        <form action="" method="POST" class="mt-5">
            <div class="form-group">
                <label for="name">Nom</label>
                <input 
                    type="text" 
                    class="form-control" 
                    name="catname" id="name" 
                    placeholder="Nom de la catégorie" 
                    value= "<?= (isset($category)? $category->getName(): '');?>">
            </div>
            <div class="form-group">
                <label for="subtitle">Sous-titre</label>
                <input 
                    type="text" 
                    class="form-control" 
                    name="subtitle" 
                    id="subtitle" 
                    placeholder="Sous-titre" 
                    aria-describedby="subtitleHelpBlock" 
                    value= "<?= (isset($category)? $category->getSubtitle(): '');?>">
                <small id="subtitleHelpBlock" class="form-text text-muted">
                    Sera affiché sur la page d'accueil comme bouton devant l'image
                </small>
            </div>
            <div class="form-group">
                <label for="picture">Image</label>
                <input 
                    type="text" 
                    class="form-control" 
                    name="picture" 
                    id="picture" 
                    placeholder="image jpg, gif, svg, png" 
                    aria-describedby="pictureHelpBlock" 
                    value= "<?= (isset($category)? $category->getPicture(): '');?>">
            </div>
            <input type="hidden" name="token" value="<?=$token?>">
            <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
        </form>
    </div>
<div class="container my-4">
        <a href="<?= $router->generate('product-list') ?>" class="btn btn-success float-right">Retour</a>
        <h2><?= (isset($mode) && $mode === 'create') ? 'Ajouter' : 'Modifier'?> un produit</h2>
        <?php include __DIR__.'/../partials/errorlist.tpl.php'?>
        <form action="" method="POST" class="mt-5">
        <div class="form-group">
            <label for="name">Nom</label>
            <input
                type="text"
                class="form-control"
                id="name"
                placeholder="Nom du produit"
                name="name"
                value= "<?=(isset($product) ? $product->getName() : '');?>"
                >
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input
                type="text"
                class="form-control"
                id="description"
                placeholder="Description"
                aria-describedby="subtitleHelpBlock"
                name="description"
                value="<?= isset($product) ? $product->getDescription() : ''; ?>"
                >
            <small id="subtitleHelpBlock" class="form-text text-muted">
                Sera affiché sur la page d'accueil comme bouton devant l'image
            </small>
        </div>
        <div class="form-group">
            <label for="price">Prix</label>
            <input
                type="text"
                class="form-control"
                id="price"
                placeholder="Prix du produit"
                aria-describedby="subtitleHelpBlock"
                name="price"
                value="<?= isset($product) ? $product->getPrice() : ''; ?>"
                >
            <small id="subtitleHelpBlock" class="form-text text-muted">
                Prix de l'article
            </small>
        </div>
        <div class="form-group">
            <label for="picture">Image</label>
            <input
                type="text"
                class="form-control"
                id="picture"
                placeholder="image jpg, gif, svg, png"
                aria-describedby="pictureHelpBlock"
                name="picture"
                value="<?= isset($product) ? $product->getPicture() : ''; ?>"
                >
        </div>
        <div class="form-group">
            <label for="brandid">Marque</label>
            <select class="form-control" id="brandid" name="brandid">
            <?php foreach($brand as $currentBrand) : ?>
                <option value="<?=$currentBrand->getId();?>"><?= $currentBrand->getName()?></option>
            <?php endforeach ?>
            </select>
            <small id="subtitleHelpBlock" class="form-text text-muted">
                Marque du produit
            </small>
        </div>
        <div class="form-group">
            <label for="categoryid">Catégorie</label>
            <select class="form-control" id="categoryid" name="categoryid">
            <?php foreach($category as $currentCategory) : ?>
                <option value="<?=$currentCategory->getId();?>"><?= $currentCategory->getName()?></option>
            <?php endforeach ?>
            </select>
            <small id="subtitleHelpBlock" class="form-text text-muted">
                Catégorie du produit
            </small>
        </div>
        <div class="form-group">
            <label for="typeid">Type</label>
            <select class="form-control" id="typeid" name="typeid">
            <?php foreach($type as $currentType) : ?>
                <option value="<?=$currentType->getId();?>"><?= $currentType->getName()?></option>
            <?php endforeach ?>
            </select>
            <small id="subtitleHelpBlock" class="form-text text-muted">
                Matière du produit
            </small>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status">
                <option value="1">Disponible</option>
                <option value="2">Indisponible</option>
            </select>
            <small id="subtitleHelpBlock" class="form-text text-muted">
                Statut du produit
            </small>
        </div>
        <input type="hidden" name="token" value="<?=$token?>">
        <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
    </form>
    </div>
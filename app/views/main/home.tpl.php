<div class="container my-4">
        <p class="display-4">
            BackOffice de la <strong>Boutique</strong>...
        </p>

        <div class="row mt-5">
            <div class="col-12 col-md-6">
                <div class="card text-white mb-3">
                    <div class="card-header bg-primary">Liste des catégories mises en avant</div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Sous-titres</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($listCategories as $categ){?>
                                <tr>
                                    <th scope="row"><?= $categ->getId() ?></th>
                                    <td><?= $categ->getName() ?></td>
                                    <td><?= $categ->getSubtitle() ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <a href="<?= $router->generate('category-list')?>" class="btn btn-block btn-success">Voir plus</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card text-white mb-3">
                    <div class="card-header bg-primary">Liste des produits</div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($listProducts as $products){?>
                                <tr>
                                    <th scope="row"><?= $products->getId() ?></th>
                                    <td><?= $products->getName() ?></td>
                                    <td><?= $products->getPrice() ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <a href="<?= $router->generate('product-list')?>" class="btn btn-block btn-success">Voir plus</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
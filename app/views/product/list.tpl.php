<div class="container my-4">
        <a href="<?= $router->generate('product-add') ?>" class="btn btn-success float-right">Ajouter</a>
        <h2>Liste des produits</h2>
        <table class="table table-hover mt-4">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Sous-titre</th>
                    <th scope="col">Status</th>
                    <th scope="col">Tags</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($allProducts as $currentProduct) { ?>
                    <tr>
                    <th scope="row"><?= $currentProduct->getId() ?></th>
                    <td><?= $currentProduct->getName() ?></td>
                    <td><?= $currentProduct->getPrice() ?> €</td>
                    <td><?= $currentProduct->getStatus() === '1' ? 'En ligne' : 'Hors ligne'?></td>
                    <td>
                    <?php 
                        $listTags = $currentProduct->getTags();
                        foreach($listTags as $currentTags):
                            echo '#'.$currentTags->getName(). ' ';
                        endforeach;?>
                    </td>    
                    <td class="text-right">
                        <a href="<?= $router->generate('product-update', ['product_id' => $currentProduct->getId()]);?>" class="btn btn-sm btn-warning">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>
                        <!-- Example single danger button -->
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-danger dropdown-toggle"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu">
                            <?php if($isAdmin){ ?>
                                <a class="dropdown-item" href="<?= $router->generate('product-delete', ['product_id' => $currentProduct->getId()]) ?>?token=<?= $token ?>">Oui, je veux supprimer</a>

                            <?php } else{?>
                                <a class="dropdown-item" href="# ?token=<?= $token ?>">Oui, je veux supprimer</a>

                            <?php }?>
                                <a class="dropdown-item" href="#" data-toggle="dropdown">Oups !</a>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
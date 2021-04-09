<div class="container my-4">
        <a href="<?= $router->generate('brand-add') ?>" class="btn btn-success float-right">Ajouter</a>
        <h2>Liste des marques</h2>
        <table class="table table-hover mt-4">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Ordre page accueil</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($allBrands as $currentBrand){ ?>
                <tr>
                    <th scope="row"><?=$currentBrand->getId()?></th>
                    <td><?=$currentBrand->getName()?></td>
                    <td><?=$currentBrand->getFooterOrder()?></td>
                    <td class="text-right">
                       <a href="<?= $router->generate('brand-update', ['brand_id' => $currentBrand->getId()]);?>" class="btn btn-sm btn-warning">
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
                            <a class="dropdown-item" href="<?= $router->generate('brand-delete', ['brand_id' => $currentBrand->getId()]) ?>?token=<?= $token ?>">Oui, je veux supprimer</a>
                            <?php } else{?>
                                <a class="dropdown-item" href="#">Oui, je veux supprimer</a>
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
    <!-- Menu Start -->
    <div class="container-fluid menu bg-light py-6 my-6 mt-0">
        <div class="container">
            <div class="text-center wow bounceInUp" data-wow-delay="0.1s">
                <small
                    class="d-inline-block fw-bold text-dark text-uppercase bg-light border border-primary rounded-pill px-4 py-1 mb-3">Our
                    Menu</small>
                <h1 class="display-5 mb-5">Rekomendasi Resep</h1>
            </div>
            <?php if (!empty($recipes)): ?>
            <div class="tab-class text-center">

                <div class="tab-content">
                    <div class="row g-4">
                        <?php foreach ($recipes as $index => $recipe): ?>

                        <div class="col-lg-6 wow bounceInUp" data-wow-delay="0.1s">
                            <div class="menu-item d-flex align-items-center">
                                <img data-src="<?= $recipe['image'] == 'assets/images/no_image_available.svg' ? '/system-recipe-v2/assets/images/no_image_available.svg' : $recipe['image'] ?>"
                                    class="lazyload flex-shrink-0 img-fluid rounded-circle" width="200" height="200">

                                <div class="w-100 d-flex flex-column text-start ps-4">
                                    <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                        <h4><?= $recipe['recipe_name'] ?></h4>
                                        <h4 class="text-primary"><?= $recipe['category'] ?></h4>
                                    </div>
                                    <p class="mb-0">
                                        <strong>Rating:</strong> <?= $recipe['rating'] ?>
                                    </p>
                                    <p class="mb-0">
                                        <strong>Cluster:</strong>
                                        <?php
                                        if ($recipe['cluster'] == "Low") {
                                            echo "Biasa-biasa saja";
                                        } elseif ($recipe['cluster'] == "High") {
                                            echo "Favorit!";
                                        } else {
                                            echo "-";
                                        }
                                        ?>
                                    </p>

                                    <!-- Button Pop-Up -->
                                    <button type="button" class="btn btn-primary px-5 py-3 rounded-pill mt-3"
                                        data-toggle="modal" data-target="#recipeModal<?= $index ?>">
                                        Lihat Resep
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Pop-Up -->
                        <div class="modal fade bd-example-modal-lg" id="recipeModal<?= $index ?>" tabindex="-1"
                            role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="text-center">
                                            <h1 class="display-5">Rekomendasi
                                                Resep</h1>
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <div class="testimonial-item rounded bg-light">
                                            <div class="d-flex mb-3">
                                                <img src="<?= $recipe['image'] == 'assets/images/no_image_available.svg' ? '/system-recipe-v2/assets/images/no_image_available.svg' : $recipe['image'] ?>"
                                                    class="flex-shrink-0 img-fluid rounded-circle" alt="" width="200"
                                                    height="200">
                                                <div class="ps-3 my-auto">
                                                    <h4 class="mb-0"><?= $recipe['recipe_name'] ?></h4>
                                                    <p class="m-0">Kategori: <b><?= $recipe['category'] ?></b></p>
                                                </div>
                                            </div>
                                            <div class="testimonial-content">
                                                <div class="d-flex">
                                                    <?php
                                                        foreach (range(1, $recipe['rating'] ) as $i) {
                                                    echo "<i class='fas fa-star text-primary'></i>" . "\n";
                                                    }
                                                    ?>
                                                </div>

                                                <div class="row mt-3">
                                                    <div class="col-4">
                                                        <div class="list-group" id="list-tab" role="tablist">
                                                            <a class="list-group-item list-group-item-action active"
                                                                id="list-home-list-<?= $recipe['recipe_name'] ?>"
                                                                data-toggle="list"
                                                                href="#list-home-<?= $recipe['recipe_name'] ?>"
                                                                role="tab" aria-controls="home">
                                                                <h6>Bahan Bahan</h6>
                                                            </a>
                                                            <a class="list-group-item list-group-item-action"
                                                                id="list-profile-list-<?= $recipe['recipe_name'] ?>"
                                                                data-toggle="list"
                                                                href="#list-profile-<?= $recipe['recipe_name'] ?>"
                                                                role="tab" aria-controls="profile">
                                                                <h6>Cara Membuat</h6>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-8">
                                                        <div class="tab-content" id="nav-tabContent">
                                                            <div class="tab-pane fade show active"
                                                                id="list-home-<?= $recipe['recipe_name'] ?>"
                                                                role="tabpanel"
                                                                aria-labelledby="list-home-list-<?= $recipe['recipe_name'] ?>">
                                                                <ul>
                                                                    <?php if (!empty($recipe['ingredients']) && is_array($recipe['ingredients'])): ?>
                                                                    <?php foreach ($recipe['ingredients'] as $ingredient): ?>
                                                                    <li>
                                                                        <p class="fs-5 m-0 pt-3">
                                                                            <?= htmlspecialchars($ingredient, ENT_QUOTES, 'UTF-8') ?>
                                                                        </p>
                                                                    </li>
                                                                    <?php endforeach; ?>
                                                                    <?php else: ?>
                                                                    <li>
                                                                        <p class="fs-5 m-0 pt-3">
                                                                            Bahan tidak tersedia.
                                                                        </p>
                                                                    </li>
                                                                    <?php endif; ?>
                                                                </ul>
                                                            </div>
                                                            <div class="tab-pane fade"
                                                                id="list-profile-<?= $recipe['recipe_name'] ?>"
                                                                role="tabpanel"
                                                                aria-labelledby="list-profile-list-<?= $recipe['recipe_name'] ?>">
                                                                <ol>
                                                                    <?php 
                                                                    if (!empty($recipe['description'])) {
                                                                        $steps = explode("\n", $recipe['description']);
                                                                        foreach ($steps as $step): ?>
                                                                    <li>
                                                                        <p class="fs-5 m-0 pt-3"><?= $step ?></p>
                                                                    </li>
                                                                    <?php endforeach;
                                                                        } else { ?>
                                                                    <p class="fs-5 m-0 pt-3">Cara membuat tidak
                                                                        tersedia.</p>
                                                                    <?php } ?>
                                                                </ol>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="col-12">
                <p class="text-muted text-center">Tidak ada resep yang sesuai dengan preferensi Anda.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- Menu End -->
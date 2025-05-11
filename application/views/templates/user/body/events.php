    <!-- Events Start -->
    <div class="container-fluid event py-6">
        <div class="container">
            <div class="text-center wow bounceInUp" data-wow-delay="0.1s">
                <small
                    class="d-inline-block fw-bold text-dark text-uppercase bg-light border border-primary rounded-pill px-4 py-1 mb-3">Latest
                    Events</small>
                <h1 class="display-5 mb-5">Rekomendasi Resep</h1>
            </div>
            <?php if (!empty($recipes)): ?>

            <div class="tab-class text-center">
                <ul class="nav nav-pills d-inline-flex justify-content-center mb-5 wow bounceInUp"
                    data-wow-delay="0.1s">
                    <li class="nav-item p-2">
                        <a class="d-flex mx-2 py-2 border border-primary bg-light rounded-pill active"
                            data-bs-toggle="pill" href="#tab-1">
                            <span class="text-dark" style="width: 150px;">All Events</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">
                                    <?php foreach ($recipes as $index => $recipe): ?>
                                    <div class="col-md-6 col-lg-3 wow bounceInUp" data-wow-delay="0.1s">
                                        <div class="event-img position-relative">
                                            <!-- Lazy Load Gambar Resep -->
                                            <img data-src="<?= $recipe['image'] == 'assets/images/no_image_available.svg' ? '/system-recipe-v2/assets/images/no_image_available.svg' : $recipe['image'] ?>"
                                                class="lazyload img-fluid rounded w-100">


                                            <div class="event-overlay d-flex flex-column p-4">
                                                <h4 class="me-auto"><?= $recipe['recipe_name'] ?></h4>
                                                <p class="card-text text-muted">
                                                    <strong>Kategori:</strong> <?= $recipe['category'] ?>
                                                </p>
                                                <p class="card-text">
                                                    <strong>Rating:</strong> <?= $recipe['rating'] ?>
                                                </p>
                                                <p class="card-text">
                                                    <strong>Cluster:</strong> <?= $recipe['cluster'] ?>
                                                </p>

                                                <!-- Button Pop-Up -->
                                                <button type="button" class="btn btn-primary px-5 py-3 rounded-pill"
                                                    data-toggle="modal" data-target="#recipeModal<?= $index ?>">
                                                    Lihat Resep
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Pop-Up -->
                                    <div class="modal fade" id="recipeModal<?= $index ?>" tabindex="-1" role="dialog"
                                        aria-labelledby="recipeModalLabel<?= $index ?>" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="recipeModalLabel<?= $index ?>">
                                                        <?= $recipe['recipe_name'] ?>
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Tabel Informasi Dasar -->
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">Kategori</th>
                                                                <td><?= $recipe['category'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Bahan Utama</th>
                                                                <td><?= $recipe['main_ingredient'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Rating</th>
                                                                <td><?= $recipe['rating'] ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                    <h6>Bahan-Bahan:</h6>
                                                    <ul>
                                                        <?php if (!empty($recipe['ingredients']) && is_array($recipe['ingredients'])): ?>
                                                        <?php foreach ($recipe['ingredients'] as $ingredient): ?>
                                                        <li><?= htmlspecialchars($ingredient, ENT_QUOTES, 'UTF-8') ?>
                                                        </li>
                                                        <?php endforeach; ?>
                                                        <?php else: ?>
                                                        <li class="text-muted">Bahan tidak tersedia.</li>
                                                        <?php endif; ?>
                                                    </ul>


                                                    <!-- Deskripsi dalam Format List -->
                                                    <h6>Cara Membuat:</h6>
                                                    <ol>
                                                        <?php 
                                                            if (!empty($recipe['description'])) {
                                                                $steps = explode("\n", $recipe['description']);
                                                                foreach ($steps as $step): ?>
                                                        <li><?= $step ?></li>
                                                        <?php endforeach;
                                                            } else { ?>
                                                        <p class="text-muted">Cara membuat tidak tersedia.</p>
                                                        <?php } ?>
                                                    </ol>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
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
    <!-- Events End -->
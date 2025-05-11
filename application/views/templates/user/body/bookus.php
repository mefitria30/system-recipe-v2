    <!-- Book Us Start -->
    <div class="container-fluid contact py-6 wow bounceInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="row g-0">
                <div class="col-1">
                    <img src="<?= base_url('assets/user/')?>img/background-site.jpg"
                        class="img-fluid h-100 w-100 rounded-start" style="object-fit: cover; opacity: 0.7;" alt="">
                </div>
                <div class="col-10">
                    <form method="post" action="/system-recipe-v2/recipes/process" class="my-4">
                        <div class="border-bottom border-top border-primary bg-light py-5 px-4">
                            <div class="text-center">
                                <small
                                    class="d-inline-block fw-bold text-dark text-uppercase bg-light border border-primary rounded-pill px-4 py-1 mb-3">KitchenRecipes</small>
                                <h1 class="display-5 mb-5">Rekomendasi Resep</h1>
                            </div>
                            <div class="row g-4 form">
                                <div class="col-lg-4 col-md-6">
                                    <select class="form-select border-primary p-2" aria-label="Default select example"
                                        id="category" name="category">
                                        <option value="all"
                                            <?= isset($_POST['category']) && $_POST['category'] == 'all' ? 'selected' : '' ?>>
                                            Pilih Kategori
                                        </option>
                                        <?php if (!empty($categories)): ?>
                                        <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category ?>"
                                            <?= isset($_POST['category']) && $_POST['category'] == $category ? 'selected' : '' ?>>
                                            <?= $category ?></option>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <div class="col-lg-4 col-md-6">
                                    <input type="number" class="form-control border-primary p-2" id="rating"
                                        name="rating" min="0" max="5" step="0.1" placeholder="Masukkan rating (0-5)"
                                        value="<?= isset($_POST['rating']) ? $_POST['rating'] : '' ?>">
                                </div>


                                <div class="col-lg-4 col-md-6">
                                    <select class="form-select border-primary p-2" id="cluster" name="cluster">
                                        <option value="all"
                                            <?= isset($_POST['cluster']) && $_POST['cluster'] == 'all' ? 'selected' : '' ?>>
                                            Semua
                                            Cluster
                                        </option>

                                        <option value="High"
                                            <?= isset($_POST['cluster']) && $_POST['cluster'] == 'High' ? 'selected' : '' ?>>
                                            Favorit
                                        </option>

                                        <option value="Low"
                                            <?= isset($_POST['cluster']) && $_POST['cluster'] == 'Low' ? 'selected' : '' ?>>
                                            Biasa-Biasa
                                            Saja
                                        </option>
                                    </select>
                                </div>

                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill">Cari
                                        Rekomendasi</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="col-1">
                    <img src="<?= base_url('assets/user/')?>img/background-site.jpg"
                        class="img-fluid h-100 w-100 rounded-end" style="object-fit: cover; opacity: 0.7;" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Book Us End -->
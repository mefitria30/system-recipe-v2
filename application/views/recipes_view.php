<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekomendasi Resep</title>
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <!-- Tambahkan script Lazysizes -->
    <script src="<?= base_url('assets/js/lazysizes.min.js') ?>" async></script>
</head>

<body>
    <div class="container">
        <div class="container">
            <!-- Tambahkan Alert untuk Feedback -->
            <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
            <?php elseif ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
            <?php endif; ?>

            <div class="text-right mb-4">
                <!-- Tombol Update -->
                <a href="/system-recipe-v2/recipes/update" class="btn btn-primary">
                    Update Rekomendasi
                </a>
            </div>

            <!-- Sisa kode untuk menampilkan data -->
        </div>

        <h1 class="mt-4 text-center">Rekomendasi Resep</h1>

        <!-- Form untuk Input Preferensi Pengguna -->
        <form method="post" action="/system-recipe-v2/recipes/process" class="my-4">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="category">Pilih Kategori:</label>
                    <select class="form-control" id="category" name="category">
                        <option value="all"
                            <?= isset($_POST['category']) && $_POST['category'] == 'all' ? 'selected' : '' ?>>Semua
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

                <div class="form-group col-md-6">
                    <label for="rating">Rating Minimal:</label>
                    <input type="number" class="form-control" id="rating" name="rating" min="0" max="5" step="0.1"
                        placeholder="Masukkan rating (0-5)"
                        value="<?= isset($_POST['rating']) ? $_POST['rating'] : '' ?>">
                </div>

                <div class="form-group col-md-6">
                    <label for="cluster">Pilih Cluster:</label>
                    <select class="form-control" id="cluster" name="cluster">
                        <option value="all">Semua Cluster</option>
                        <option value="High">Favorit</option>
                        <option value="Low">Biasa-Biasa Saja</option>
                    </select>
                </div>

            </div>

            <button type="submit" class="btn btn-primary btn-block">Cari Rekomendasi</button>
        </form>


        <!-- Hasil Rekomendasi -->
        <div class="mt-5">
            <h2 class="text-center">Hasil Rekomendasi</h2>
            <div class="row">
                <?php if (!empty($recipes)): ?>
                <?php foreach ($recipes as $index => $recipe): ?>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <!-- Lazy Load Gambar Resep -->
                        <img data-src="<?= $recipe['image'] == 'assets/images/no_image_available.svg' ? '/system-recipe-v2/assets/images/no_image_available.svg' : $recipe['image'] ?>"
                            class="lazyload card-img-top">

                        <div class=" card-body">
                            <h5 class="card-title"><?= $recipe['recipe_name'] ?></h5>
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
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#recipeModal<?= $index ?>">
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
                                <h5 class="modal-title" id="recipeModalLabel<?= $index ?>"><?= $recipe['recipe_name'] ?>
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                    <li><?= htmlspecialchars($ingredient, ENT_QUOTES, 'UTF-8') ?></li>
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
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <div class="col-12">
                    <p class="text-muted text-center">Tidak ada resep yang sesuai dengan preferensi Anda.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>

</body>

</html>
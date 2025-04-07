<?php
class Recipes extends CI_Controller {
    public function index() {
        $this->load->model('Recipe_model'); // Load model Recipe_model

        // Ambil semua data resep gabungan (API + database lokal)
        $recipes = $this->Recipe_model->get_combined_data();

        // Ambil daftar kategori untuk dropdown
        $categories = $this->Recipe_model->get_all_categories();

        // Kirim data ke view
        $data['recipes'] = $recipes; // Data resep
        $data['categories'] = $categories; // Data kategori untuk dropdown
        $this->load->view('recipes_view', $data);
    }

    public function process() {
        $this->load->model('Recipe_model'); // Load model Recipe_model

        // Ambil input pengguna
        $category = $this->input->post('category'); // Kategori
        $min_rating = $this->input->post('rating'); // Rating minimal

        // Ambil semua data resep gabungan
        $recipes = $this->Recipe_model->get_combined_data();

        // Filter data berdasarkan preferensi pengguna
        $filtered_recipes = array_filter($recipes, function($recipe) use ($category, $min_rating) {
            $is_category_match = $category == 'all' || $recipe['category'] == $category;
            $is_rating_match = isset($recipe['rating']) && $recipe['rating'] >= $min_rating;
            return $is_category_match && $is_rating_match;
        });

        // Ambil daftar kategori untuk dropdown
        $categories = $this->Recipe_model->get_all_categories();

        // Kirim data hasil filter ke view
        $data['recipes'] = $filtered_recipes; // Data yang difilter
        $data['categories'] = $categories; // Dropdown kategori
        $this->load->view('recipes_view', $data);
    }
}
?>
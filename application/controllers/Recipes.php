<?php
class Recipes extends CI_Controller {
    public function index() {
        $this->load->model('Recipe_model'); // Load model Recipe_model

        // Ambil data yang mencakup database, API, dan rekomendasi CSV
        $recipes = $this->Recipe_model->get_combined_data();

        // Ambil daftar kategori untuk dropdown
        $categories = $this->Recipe_model->get_all_categories();

        // Kirim data ke view
        $data['recipes'] = $recipes;
        $data['categories'] = $categories;
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

    public function update_recommendations() {
        $output = [];
        $return_var = 0;

        // Replace with the actual path to your Python executable
        $command = escapeshellcmd('C:/Python310/python.exe C:/xampp/htdocs/system-recipe-v2/python_backend/app.py');
        exec($command . ' 2>&1', $output, $return_var);

        // Log output for debugging
        error_log('Command executed: ' . $command);
        error_log('Output Python: ' . print_r($output, true));
        error_log('Return var: ' . $return_var);

        // Check success or error
        if ($return_var === 0) {
            $this->session->set_flashdata('success', 'Data rekomendasi berhasil diperbarui!');
        } else {
            $this->session->set_flashdata('error', 'Terjadi kesalahan saat memperbarui data rekomendasi: ' . implode('<br>', $output));
        }

        redirect(base_url());
    }


}
?>
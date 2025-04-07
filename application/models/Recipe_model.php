<?php
class Recipe_model extends CI_Model {
    public function get_all_recipes() {
        $query = $this->db->get('recipes');
        $recipes = $query->result_array();

        foreach ($recipes as &$recipe) {
            // Build full image path or fallback to default image
            $recipe['image'] = !empty($recipe['image_name']) 
                ? base_url('assets/images/recipes/' . $recipe['image_name']) 
                : 'https://upload.wikimedia.org/wikipedia/commons/a/ac/No_image_available.svg';

        }

        return $recipes;
    }



    public function fetch_meal_db() {
        $api_url = "https://www.themealdb.com/api/json/v1/1/search.php?s=";
        $response = file_get_contents($api_url);
        $data = json_decode($response, true);

        $api_recipes = [];
        if (!empty($data['meals'])) {
            foreach ($data['meals'] as $meal) {
                $api_recipes[] = [
                    'recipe_name' => $meal['strMeal'],
                    'category' => $meal['strCategory'],
                    'main_ingredient' => !empty($meal['strIngredient1']) ? $meal['strIngredient1'] : $meal['strCategory'], // Gunakan kategori jika bahan utama kosong
                    'rating' => rand(1, 5), // Random rating
                    'description' => !empty($meal['strInstructions']) ? $meal['strInstructions'] : 'Deskripsi tidak tersedia.',
                    'image' => !empty($meal['strMealThumb']) ? $meal['strMealThumb'] : 'https://upload.wikimedia.org/wikipedia/commons/a/ac/No_image_available.svg',
                ];
            }
        }
        return $api_recipes;
    }

    
    public function get_combined_data() {
        // Ambil data dari API
        $api_recipes = $this->fetch_meal_db(); // Data dari API

        // Ambil data dari database
        $local_recipes = $this->get_all_recipes(); // Data dari database

        // Ambil data dari file CSV
        $file = fopen('python_backend/recommendations.csv', 'r');
        $csv_recipes = [];
        $header = fgetcsv($file);
        while (($data = fgetcsv($file)) !== FALSE) {
            $csv_recipes[] = array_combine($header, $data);
        }
        fclose($file);

        // Gabungkan data dengan prioritas API
        $combined_data = array_merge($api_recipes, $local_recipes, $csv_recipes);

        // Hapus duplikasi berdasarkan nama resep
        $unique_data = [];
        foreach ($combined_data as $recipe) {
            $unique_key = $recipe['recipe_name']; // Prioritaskan resep berdasarkan nama
            if (!isset($unique_data[$unique_key])) {
                $unique_data[$unique_key] = $recipe; // Masukkan resep jika belum ada
            }
        }

        return array_values($unique_data); // Kembalikan data tanpa duplikasi
    }




    public function get_all_categories() {
        // Ambil kategori dari database
        $db_query = $this->db->select('DISTINCT(category)')->get('recipes');
        $db_categories = array_column($db_query->result_array(), 'category');

        // Debug data dari database
        error_log("Database Categories: " . print_r($db_categories, true));

        // Ambil kategori dari API
        $api_recipes = $this->fetch_meal_db();
        $api_categories = array_unique(array_column($api_recipes, 'category'));

        // Debug data dari API
        error_log("API Categories: " . print_r($api_categories, true));

        // Gabungkan kategori dari database dan API
        $all_categories = array_unique(array_merge($db_categories, $api_categories));
        sort($all_categories);

        // Debug hasil akhir
        error_log("All Categories: " . print_r($all_categories, true));

        return $all_categories;
    }

}
?>
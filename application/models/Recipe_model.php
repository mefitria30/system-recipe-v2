<?php
class Recipe_model extends CI_Model {
    public function get_all_recipes() {
        $query = $this->db->get('recipes');
        return $query->result_array();
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
        $local_recipes = $this->get_all_recipes(); // Data dari database
        $api_recipes = $this->fetch_meal_db();     // Data dari API
        return array_merge($local_recipes, $api_recipes); // Gabungkan data
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
<?php
class Recipe_model extends CI_Model {
    private function is_connected() {
        $connected = @fsockopen("www.google.com", 80); // Coba koneksi ke Google
        if ($connected) {
            fclose($connected);
            return true; // Koneksi tersedia
        }
        return false; // Koneksi tidak tersedia
    }


    public function get_all_recipes() {
        $query = $this->db->get('recipes');
        $recipes = $query->result_array();

        foreach ($recipes as &$recipe) {
            $recipe['image'] = !empty($recipe['image_name']) 
                ? base_url('assets/images/recipes/' . $recipe['image_name']) 
                : base_url('assets/images/no_image_available.svg');
            $recipe['ingredients'] = !empty($recipe['ingredients']) 
                ? explode("\n", $recipe['ingredients']) 
                : ['Bahan tidak tersedia'];
        }

        return $recipes;
    }


    public function fetch_meal_db() {
        $api_url = "https://www.themealdb.com/api/json/v1/1/search.php?s=";

        if ($this->is_connected()) {
            try {
                $response = file_get_contents($api_url);
                if ($response === FALSE) {
                    throw new Exception("API not accessible.");
                }
                $data = json_decode($response, true);

                $api_recipes = [];
                if (!empty($data['meals'])) {
                    foreach ($data['meals'] as $meal) {
                        $ingredients = [];
                        for ($i = 1; $i <= 20; $i++) {
                            $ingredient = $meal["strIngredient{$i}"];
                            $measure = $meal["strMeasure{$i}"];
                            if (!empty($ingredient)) {
                                $ingredients[] = "{$measure} {$ingredient}";
                            }
                        }

                        $api_recipes[] = [
                            'recipe_name' => $meal['strMeal'],
                            'category' => $meal['strCategory'],
                            'ingredients' => $ingredients, // Tambahkan bahan-bahan ke array
                            'main_ingredient' => $meal['strIngredient1'] ?? 'Unknown',
                            'rating' => rand(1, 5),
                            'description' => $meal['strInstructions'] ?? 'Deskripsi tidak tersedia.',
                            'image' => $meal['strMealThumb'] ?? base_url('assets/images/no_image_available.svg'),
                        ];
                    }

                }
                return $api_recipes;

            } catch (Exception $e) {
                error_log("Error accessing API: " . $e->getMessage());
                return [];
            }
        } else {
            error_log("No internet connection. Using local data only.");
            return []; // Data kosong saat offline
        }
    }


    
    public function get_combined_data() {
        $local_recipes = $this->get_all_recipes(); // Data lokal
        $api_recipes = $this->fetch_meal_db();    // Data API (atau kosong jika offline)

        $file = fopen('python_backend/recommendations.csv', 'r');
        $csv_recipes = [];
        $header = fgetcsv($file);
        while (($data = fgetcsv($file)) !== FALSE) {
            $csv_recipes[] = array_combine($header, $data);
        }
        fclose($file);

        $combined_data = array_merge($api_recipes, $local_recipes, $csv_recipes);

        $unique_data = [];
        foreach ($combined_data as $recipe) {
            $unique_key = $recipe['recipe_name'];
            if (!isset($unique_data[$unique_key])) {
                $unique_data[$unique_key] = $recipe;
            }
        }

        return array_values($unique_data);
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
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
                ? '/system-recipe-v2/assets/images/recipes/' . $recipe['image_name'] 
                : '/system-recipe-v2/assets/images/no_image_available.svg';
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
        $api_recipes = $this->fetch_meal_db();    // Data API
        $file = fopen('python_backend/recommendations.csv', 'r'); // Data CSV
        $csv_recipes = [];
        $header = fgetcsv($file);
        while (($data = fgetcsv($file)) !== FALSE) {
            $csv_recipes[] = array_combine($header, $data);
        }
        fclose($file);

        $local_recipes = $this->get_all_recipes(); // Data lokal

        // Gabungkan data sesuai prioritas: API -> CSV -> Lokal
        $combined_data = array_merge($api_recipes, $csv_recipes, $local_recipes);

        // Tetapkan cluster secara dinamis jika cluster tidak ada
        foreach ($combined_data as &$recipe) {
            if (!isset($recipe['ingredients']) || !is_array($recipe['ingredients'])) {
                // Jika ingredients berupa string, ubah ke array
                $recipe['ingredients'] = is_string($recipe['ingredients'])
                    ? array_filter(explode("\n", $recipe['ingredients'])) // Hapus elemen kosong
                    : ['Bahan tidak tersedia'];
            }

            // Jika ingredients berupa array tetapi kosong, tambahkan pesan default
            if (empty($recipe['ingredients'])) {
                $recipe['ingredients'] = ['Bahan tidak tersedia'];
            }
            
            if (!isset($recipe['cluster']) || empty($recipe['cluster'])) {
                if (isset($recipe['rating']) && is_numeric($recipe['rating'])) {
                    $recipe['cluster'] = $recipe['rating'] >= 4 ? 'High' : 'Low';
                } else {
                    $recipe['cluster'] = 'Low'; // Tetapkan sebagai "Low" jika rating tidak tersedia
                }
            }
        }

        // Hapus duplikasi berdasarkan nama resep (recipe_name)
        $unique_data = [];
        foreach ($combined_data as $recipe) {
            $unique_key = strtolower(trim($recipe['recipe_name'])); // Nama normalisasi
            if (!isset($unique_data[$unique_key])) {
                $unique_data[$unique_key] = $recipe; // Ambil data pertama sesuai prioritas
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
import pymysql
import pandas as pd
import numpy as np
import requests

# Fungsi untuk mengambil data dari database MySQL
def fetch_data_from_db():
    connection = pymysql.connect(
        host='localhost',
        user='root',
        password='',  # Your MySQL password
        database='db-system-recipe-v2'
    )
    
    query = "SELECT * FROM recipes"
    local_data = pd.read_sql(query, connection)

    api_url = "https://www.themealdb.com/api/json/v1/1/search.php?s="
    
    # Enrichment untuk kategori, bahan utama, deskripsi, dan ingredients
    for index, recipe in local_data.iterrows():
        if (pd.isnull(recipe['category']) or 
            pd.isnull(recipe['main_ingredient']) or 
            pd.isnull(recipe['description']) or 
            pd.isnull(recipe['ingredients'])):  # Periksa kolom ingredients juga
            response = requests.get(api_url + recipe['recipe_name'])
            if response.status_code == 200:
                api_data = response.json().get('meals', [])
                if api_data:
                    meal = api_data[0]

                    # Ambil ingredients dari API
                    ingredients = []
                    for i in range(1, 21):  # Iterasi hingga 20 bahan
                        ingredient = meal.get(f"strIngredient{i}")
                        measure = meal.get(f"strMeasure{i}")
                        if ingredient and ingredient.strip() != "":
                            ingredients.append(f"{measure} {ingredient}".strip())

                    # Gabungkan bahan menjadi string
                    ingredients_string = "\n".join(ingredients)

                    # Update data lokal
                    cursor = connection.cursor()
                    update_query = """
                    UPDATE recipes SET category=%s, main_ingredient=%s, description=%s, ingredients=%s WHERE id=%s
                    """
                    cursor.execute(update_query, (
                        meal.get('strCategory', 'Miscellaneous'),
                        meal.get('strIngredient1', 'Unknown'),
                        meal.get('strInstructions', 'Deskripsi tidak tersedia.'),
                        ingredients_string,
                        recipe['id']
                    ))
                    connection.commit()

    # Ambil data terbaru setelah enrichment
    updated_data = pd.read_sql(query, connection)

    # Tambahkan path gambar default jika gambar kosong
    updated_data['image'] = updated_data['image_name'].apply(
        lambda x: f"/system-recipe-v2/assets/images/recipes/{x}" if pd.notnull(x) else "/system-recipe-v2/assets/images/no_image_available.svg"
    )


    connection.close()
    return updated_data


# Fungsi untuk mengambil data dari API Meal DB
def fetch_meal_db():
    url = "https://www.themealdb.com/api/json/v1/1/search.php?s="
    response = requests.get(url)
    if response.status_code == 200:
        meals = response.json()['meals']
        api_data = []
        for meal in meals:
            # Ambil ingredients dari API
            ingredients = []
            for i in range(1, 21):  # Iterasi hingga 20 bahan
                ingredient = meal.get(f"strIngredient{i}")
                measure = meal.get(f"strMeasure{i}")
                if ingredient and ingredient.strip() != "":
                    ingredients.append(f"{measure} {ingredient}".strip())

            # Gabungkan bahan menjadi string
            ingredients_string = "\n".join(ingredients)

            # Simpan data API
            api_data.append({
                "id": meal['idMeal'],
                "recipe_name": meal['strMeal'],
                "category": meal['strCategory'],
                "main_ingredient": "API",
                "rating": round(np.random.uniform(1.0, 5.0)),  # Rating dibulatkan
                "description": meal['strInstructions'] if meal['strInstructions'] else 'Deskripsi tidak tersedia.',
                "ingredients": ingredients_string,
                "image": meal['strMealThumb'] if meal['strMealThumb'] else "assets/images/no_image_available.svg"
            })
        return pd.DataFrame(api_data)
    return pd.DataFrame()


# Fungsi utama untuk menghasilkan rekomendasi
def generate_recommendations():
    try:
        # Gabungkan data dari database dan API
        db_data = fetch_data_from_db()
        api_data = fetch_meal_db()
        combined_data = pd.concat([db_data, api_data], ignore_index=True)

        # Hapus duplikasi berdasarkan nama resep (recipe_name)
        combined_data = combined_data.drop_duplicates(subset=['recipe_name'], keep='last')

        # Tambahkan kolom cluster berdasarkan threshold rating
        combined_data['cluster'] = combined_data['rating'].apply(
            lambda x: 'High' if x >= 4 else 'Low' if pd.notnull(x) else 'Low'
        )

        # Sorting berdasarkan rating tertinggi
        combined_data = combined_data.sort_values(by='rating', ascending=False, na_position='last')

        # Simpan hasil ke file CSV
        combined_data.to_csv("recommendations.csv", index=False)
        print("Data rekomendasi tanpa duplikasi telah disimpan ke 'recommendations.csv'")

    except Exception as e:
        print(f"Terjadi kesalahan: {e}")

# Eksekusi script
if __name__ == "__main__":
    generate_recommendations()

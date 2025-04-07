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
    
    # Enrich missing fields
    for index, recipe in local_data.iterrows():
        if pd.isnull(recipe['category']) or pd.isnull(recipe['main_ingredient']) or pd.isnull(recipe['description']):
            response = requests.get(api_url + recipe['recipe_name'])
            if response.status_code == 200:
                api_data = response.json().get('meals', [])
                if api_data:
                    meal = api_data[0]
                    # Update missing fields
                    cursor = connection.cursor()
                    update_query = """
                    UPDATE recipes SET category=%s, main_ingredient=%s, description=%s WHERE id=%s
                    """
                    cursor.execute(update_query, (
                        meal.get('strCategory', 'Miscellaneous'),
                        meal.get('strIngredient1', 'Unknown'),
                        meal.get('strInstructions', 'Deskripsi tidak tersedia.'),
                        recipe['id']
                    ))
                    connection.commit()

    # Fetch updated data
    updated_data = pd.read_sql(query, connection)
    updated_data['image'] = updated_data['image_name'].apply(
        lambda x: f"assets/images/recipes/{x}" if pd.notnull(x) else "assets/images/no_image_available.svg"
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
            api_data.append({
                "id": meal['idMeal'],  # Gunakan idMeal sebagai ID
                "recipe_name": meal['strMeal'],
                "category": meal['strCategory'],
                "main_ingredient": "API",
                "rating": round(np.random.uniform(1.0, 5.0)),  # Rating random
            })
        return pd.DataFrame(api_data)
    return pd.DataFrame()

# Fungsi utama untuk menghasilkan rekomendasi
def generate_recommendations():
    # Gabungkan data dari database dan API
    db_data = fetch_data_from_db()
    api_data = fetch_meal_db()
    combined_data = pd.concat([db_data, api_data], ignore_index=True)

    # Sorting berdasarkan rating tertinggi
    combined_data = combined_data.sort_values(by='rating', ascending=False)
    
    # Simpan hasil ke file CSV
    combined_data.to_csv("recommendations.csv", index=False)
    print("Data rekomendasi telah disimpan ke 'recommendations.csv'")

# Eksekusi script
if __name__ == "__main__":
    generate_recommendations()

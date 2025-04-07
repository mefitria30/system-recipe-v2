import pymysql
import pandas as pd
import numpy as np
from sklearn.cluster import KMeans
from numpy.linalg import svd
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
        lambda x: f"assets/images/recipes/{x}" if pd.notnull(x) else "https://upload.wikimedia.org/wikipedia/commons/a/ac/No_image_available.svg"
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
                "recipe_name": meal['strMeal'],
                "category": meal['strCategory'],
                "main_ingredient": "API",
                "rating": np.random.uniform(1.0, 5.0)  # Rating random
            })
        return pd.DataFrame(api_data)
    return pd.DataFrame()

# Fungsi utama untuk menghasilkan rekomendasi
def generate_recommendations():
    # Gabungkan data dari database dan API
    db_data = fetch_data_from_db()
    api_data = fetch_meal_db()
    combined_data = pd.concat([db_data, api_data], ignore_index=True)

    # Algoritma K-Means dan SVD
    ratings = np.random.rand(len(combined_data), len(combined_data))  # Square matrix
    U, S, VT = svd(ratings)

    # Adjust matrix multiplication for alignment
    predicted = np.dot(U, np.dot(np.diag(S[:len(U)]), VT[:len(U), :]))

    # Apply K-Means clustering
    kmeans = KMeans(n_clusters=3, random_state=0).fit(predicted)
    combined_data['Cluster'] = kmeans.labels_


    # Simpan hasil ke file CSV
    combined_data.to_csv("recommendations.csv", index=False)
    print("Data rekomendasi telah disimpan ke 'recommendations.csv'")

# Eksekusi script
if __name__ == "__main__":
    generate_recommendations()

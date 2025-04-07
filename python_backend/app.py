from flask import Flask, jsonify
from sklearn.cluster import KMeans
from numpy.linalg import svd
import pymysql
import pandas as pd
import numpy as np
import requests

app = Flask(__name__)

# Fungsi untuk mengambil data dari database MySQL
def fetch_data_from_db():
    connection = pymysql.connect(
        host='localhost',
        user='root',
        password='',  # Ganti sesuai konfigurasi
        database='system_recipe_v2'
    )
    query = "SELECT * FROM recipes"
    data = pd.read_sql(query, connection)
    connection.close()
    return data

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

# Endpoint rekomendasi
@app.route('/recommendations', methods=['GET'])
def get_recommendations():
    # Ambil data dari database dan API
    db_data = fetch_data_from_db()
    api_data = fetch_meal_db()
    combined_data = pd.concat([db_data, api_data], ignore_index=True)

    # Algoritma K-Means dan SVD
    ratings = np.random.rand(len(combined_data), 5)  # Dummy matrix rating
    U, S, VT = svd(ratings)
    predicted = np.dot(U, np.dot(np.diag(S), VT))

    # K-Means clustering
    kmeans = KMeans(n_clusters=3, random_state=0).fit(predicted)
    combined_data['Cluster'] = kmeans.labels_

    # Return data sebagai JSON
    return jsonify(combined_data.to_dict(orient='records'))

if __name__ == '__main__':
    app.run(debug=True)

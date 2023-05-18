import http.client
import json

def get_movies_by_ids(ids_list):
    conn = http.client.HTTPSConnection("moviesdatabase.p.rapidapi.com")

    headers = {
        'X-RapidAPI-Key': "935104ce7dmsh63f3fd50111889cp14cf54jsncc1f976742bb",
        'X-RapidAPI-Host': "moviesdatabase.p.rapidapi.com"
    }

    query_params = ",".join(ids_list)
    conn.request("GET", "/titles/x/titles-by-ids?idsList=" + query_params, headers=headers)

    res = conn.getresponse()
    data = res.read()

    movies = json.loads(data.decode("utf-8"))

    return movies

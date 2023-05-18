<?php

// $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
// $client = new \GuzzleHttp\Client();

// $response = $client->request('GET', 'https://moviesdatabase.p.rapidapi.com/titles', [
// 	'headers' => [
// 		'X-RapidAPI-Host' => 'moviesdatabase.p.rapidapi.com',
// 		'X-RapidAPI-Key' => '935104ce7dmsh63f3fd50111889cp14cf54jsncc1f976742bb',
// 	],
// 	'query' => [
// 		'title' => $searchQuery,
// 	],
// ]);

// echo $response->getBody();
?>
<?php

if (isset($_GET['search'])) {
  $searchQuery = $_GET['search'];
  $curl = curl_init();

  curl_setopt_array($curl, [
    CURLOPT_URL => "https://moviesdatabase.p.rapidapi.com/titles?search=".$searchQuery,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => [
      "X-RapidAPI-Host: moviesdatabase.p.rapidapi.com",
      "X-RapidAPI-Key: 935104ce7dmsh63f3fd50111889cp14cf54jsncc1f976742bb"
    ],
  ]);

  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);

  if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    echo $response;
  }
}
?>


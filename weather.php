<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "weather_app";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cityName = $_POST['city_name'];
    
    if (empty($cityName)) {
        echo json_encode(['error' => 'Você precisa digitar uma cidade...']);
        exit;
    }

    $apiKey = '10a7503de12c6fb215fc96cbc5f07072';
    $apiUrl = "https://api.openweathermap.org/data/2.5/weather?q=" . urlencode($cityName) . "&appid=" . $apiKey . "&units=metric&lang=pt_br";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $json = json_decode($response, true);

    if ($json['cod'] == 200) {
        $city = $json['name'];
        $country = $json['sys']['country'];
        $temp = $json['main']['temp'];
        $tempMax = $json['main']['temp_max'];
        $tempMin = $json['main']['temp_min'];
        $description = $json['weather'][0]['description'];
        $icon = $json['weather'][0]['icon'];

		$stmt = $conn->prepare("INSERT INTO logs (city_name, country, temperature, temp_max, temp_min, description) VALUES (?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("ssddss", $city, $country, $temp, $tempMax, $tempMin, $description);
        $stmt->execute();
        $stmt->close();

        echo json_encode([
            'city' => $city,
            'country' => $country,
            'temp' => $temp,
            'tempMax' => $tempMax,
            'tempMin' => $tempMin,
            'description' => $description,
            'tempIcon' => $icon
        ]);
    } else {
        echo json_encode(['error' => 'Não foi possível localizar...']);
    }
}

$conn->close();
?>
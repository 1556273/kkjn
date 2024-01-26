<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "store_data";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully" . "<br/>";
}

$curl = curl_init('https://swapi.dev/api/planets/');
if (!$curl) {
    die("Couldn't initialize a cURL handle");
}

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($curl);

if (curl_errno($curl)) {
    echo(curl_error($curl));
    die();
}

curl_close($curl);

$response_data = json_decode($result, true);

foreach ($response_data['results'] as $item) {
    $name = $item['name'];
    $rotation_period = $item['rotation_period'];
    $orbital_period = $item['orbital_period'];
    $diameter = $item['diameter'];
    $climate = $item['climate'];
    $gravity = $item['gravity'];
    $terrain = $item['terrain'];
    $surface_water = $item['surface_water'];
    $population = $item['population'];
    $created = date("Y-m-d H:i:s", strtotime($item['created']));
    $edited = date("Y-m-d H:i:s", strtotime($item['edited']));
    $api = $item['url'];

    $query = "INSERT INTO starwarstable (
        Name,
        rotation_period,
        orbital_period,
        diameter,
        climate,
        gravity,
        terrain,
        surface_water,
        population,
        created,
        edited,
        API
    ) VALUES (
        '$name',
        $rotation_period,
        $orbital_period,
        '$diameter',
        '$climate',
        '$gravity',
        '$terrain',
        '$surface_water',
        $population,
        '$created',
        '$edited',
        '$api'
    )";
    if ($conn->query($query) === TRUE) {
        echo "Record inserted successfully" . "<br/>";
    } else {
        echo "Error inserting record: " . $conn->error;
    }
}

$conn->close();
?>

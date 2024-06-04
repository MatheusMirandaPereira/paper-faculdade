<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "weather_app";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$sql = "SELECT city_name, country, temperature, temp_max, temp_min, description, dtLog FROM logs";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logs</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap">
	<link rel="shortcut icon" href="src/ico/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="src/styles/styles.css">
</head>
<body>
    <div id="container">
        <h2>Histórico de Buscas</h2>
        <table>
            <thead>
                <tr>
                    <th>Cidade</th>
                    <th>País</th>
                    <th>Temperatura</th>
                    <th>Temperatura Max.</th>
                    <th>Temperatura Min.</th>
                    <th>Descrição</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>".$row["city_name"]."</td>";
                        echo "<td>".$row["country"]."</td>";
                        echo "<td>".$row["temperature"]."</td>";
                        echo "<td>".$row["temp_max"]."</td>";
                        echo "<td>".$row["temp_min"]."</td>";
                        echo "<td>".$row["description"]."</td>";
                        echo "<td>".date('d/m/Y H:i:s', strtotime($row["dtLog"]))."</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Não há registros na tabela de logs.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$user = "root";
$password = "";
$database = "blog";
$table = "posts"; 
$host ="localhost";

try {
    $db = new PDO("mysql:host=$host;dbname=$database", $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Agregar esta línea para mostrar errores
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

// Consulta SQL para obtener los datos de la tabla 'posts'
$query = "SELECT id, title, status, content, user_id FROM $table";
$stmt = $db->query($query);

// Crear un array para almacenar los datos
$data = array();

// Iterar a través de los resultados y almacenar cada fila en el array
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $data[] = $row;
}

// Convertir el array en formato JSON
$jsonData = json_encode($data);

// Guardar el JSON en un archivo llamado "registros.json"
$file = fopen('registros.json', 'w');
if ($file) {
    fwrite($file, $jsonData);
    fclose($file);
    echo "Datos guardados en registros.json";
} else {
    echo "Error al abrir el archivo para escritura.";
}

// Mostrar los datos en la página PHP
echo "<h1>Lista de Posts</h1>";

if (!empty($data)) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Estado</th>
                <th>Contenido</th>
                <th>ID de Usuario</th>
            </tr>";

    foreach ($data as $row) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['title'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
        echo "<td>" . $row['content'] . "</td>";
        echo "<td>" . $row['user_id'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No hay datos disponibles.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Posts</title>
    <meta charset="UTF-8">
</head>
<body>
    <!-- Tu tabla HTML aquí -->
</body>
</html>

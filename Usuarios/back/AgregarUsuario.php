<?php
try {
    require_once "./conexion.php";
    
    // Obtener el JSON enviado
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['nombre']) && isset($data['apellido']) && isset($data['email']) && isset($data['celular'])) {
        $nombre = $data['nombre'];
        $apellido = $data['apellido'];
        $email = $data['email'];
        $celular = $data['celular'];

        // Insertar el nuevo usuario
        $sql = "INSERT INTO user (nombre, apellido, email, celular) VALUES (:nombre, :apellido, :email, :celular)";
        $stmt = $objetoConexionDb->prepare($sql);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':celular', $celular, PDO::PARAM_STR);
        $stmt->execute();

        $objetoConexionDb = null;
        $stmt = null;

        echo json_encode(['success' => true, 'message' => 'Se ha agregado exitosamente al usuario ' ]);
    } else {
        echo json_encode(['error' => 'Datos de usuario no proporcionados correctamente']);
    }
} catch (PDOException $error) {
    echo json_encode(['error' => "Fallo de conexión: " . $error->getMessage()]);
}

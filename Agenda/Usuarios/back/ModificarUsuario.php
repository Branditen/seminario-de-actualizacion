<?php
try {
    require_once "./conexion.php";
    
    // Obtener el JSON enviado
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['id_usuario']) && isset($data['nombre']) && isset($data['apellido']) && isset($data['email']) && isset($data['celular'])) {
        $userId = $data['id_usuario'];
        $nombre = $data['nombre'];
        $apellido = $data['apellido'];
        $email = $data['email'];
        $celular = $data['celular'];

        // Comprobar si el usuario existe
        $sql = "SELECT * FROM user WHERE id_usuario = :id_usuario";
        $stmt = $objetoConexionDb->prepare($sql);
        $stmt->bindParam(':id_usuario', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Actualizar el usuario
            $sql = "UPDATE user SET nombre = :nombre, apellido = :apellido, email = :email, celular = :celular WHERE id_usuario = :id_usuario";
            $stmt = $objetoConexionDb->prepare($sql);
            $stmt->bindParam(':id_usuario', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':celular', $celular, PDO::PARAM_STR);
            $stmt->execute();


            echo json_encode(['success' => true, 'message' => 'Usuario actualizado']);
        } else {
            echo json_encode(['error' => 'El usuario no existe']);
        }
        $objetoConexionDb = null;
        $stmt = null;
    } else {
        echo json_encode(['error' => 'Datos de usuario no proporcionados correctamente']);
    }
} catch (PDOException $error) {
    echo json_encode(['error' => "Fallo de conexión: " . $error->getMessage()]);
}
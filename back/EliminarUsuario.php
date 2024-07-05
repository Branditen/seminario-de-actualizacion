<?php
try {
    require_once "./conexion.php";

    // Obtener el JSON enviado
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['id'])) {
        $userId = $data['id'];

        // Comprobar si el usuario existe
        $sql = "SELECT * FROM user WHERE id_usuario = :id";
        $stmt = $objetoConexionDb->prepare($sql);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Eliminar el usuario
            $sql = "DELETE FROM user WHERE id_usuario = :id";
            $stmt = $objetoConexionDb->prepare($sql);
            $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
            $stmt->execute();

            echo json_encode(['success' => true, 'message' => 'Usuario eliminado']);
        } else {
            echo json_encode(['error' => 'El usuario no existe']);
        }
        $objetoConexionDb = null;
        $stmt = null;
    } else {
        echo json_encode(['error' => 'ID de usuario no proporcionado']);
    }
} catch (PDOException $error) {
    echo json_encode(['error' => "Fallo de conexión: " . $error->getMessage()]);
}
<?php
try {
    require_once "./conexion.php";

    // Obtener el JSON enviado
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['id'])) {
        
        $sql_name = "select";

        $query = "SELECT sql_instruccion FROM sql_table WHERE sql_name = :sql_name";
        
        $stmt = $objetoConexionDb->prepare($query);
        $stmt->bindParam(':sql_name', $sql_name, PDO::PARAM_STR);
        $stmt->execute();

        $query_content = $stmt->fetchColumn();

        
        $userId = $data['id'];

        // Comprobar si el usuario existe
        $sql = $query_content;
        $stmt = $objetoConexionDb->prepare($sql);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Eliminar el usuario
            $sql_name = "delete";

            $query = "SELECT sql_instruccion FROM sql_table WHERE sql_name = :sql_name";
            
            $stmt = $objetoConexionDb->prepare($query);
            $stmt->bindParam(':sql_name', $sql_name, PDO::PARAM_STR);
            $stmt->execute();

            $query_content = $stmt->fetchColumn();
            
            $sql = $query_content;
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
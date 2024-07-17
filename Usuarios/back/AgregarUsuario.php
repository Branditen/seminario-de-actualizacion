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

        $sql_name = "insert";
        $query = "SELECT sql_instruccion FROM sql_table WHERE sql_name = :sql_name";
        
        $stmt = $objetoConexionDb->prepare($query);
        $stmt->bindParam(':sql_name', $sql_name, PDO::PARAM_STR);
        $stmt->execute();

        $query_content = $stmt->fetchColumn();
        
        // Insertar el nuevo usuario
        $sql = $query_content;
        $stmt = $objetoConexionDb->prepare($sql);
        
        $stmt->execute([$nombre,$apellido,$email,$celular]);

        $objetoConexionDb = null;
        $stmt = null;

        echo json_encode(['success' => true, 'message' => 'Se ha agregado exitosamente al usuario ' ]);
    } else {
        echo json_encode(['error' => 'Datos de usuario no proporcionados correctamente']);
    }
} catch (PDOException $error) {
    echo json_encode(['error' => "Fallo de conexión: " . $error->getMessage()]);
}

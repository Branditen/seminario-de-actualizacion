<?php
try {
    require_once "./conexion.php";
    
    // Consulta para obtener los datos
    $sql = "SELECT id_usuario, nombre, apellido, email, celular FROM user";
    $stmt = $objetoConexionDb->prepare($sql);
    $stmt->execute();

    // Obtener los resultados
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Devolver datos en formato JSON
    header('Content-Type: text/html');
    
    $objetoConexionDb = null;
    $stmt = null;

    echo json_encode($usuarios);

} catch (PDOException $error) {
    echo json_encode(['success' => false, 'message' => "Fallo de conexión: " . $error->getMessage()]);
    echo "Fallo de conexión: " . $error->getMessage();
}
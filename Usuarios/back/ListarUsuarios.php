<?php
try {
    require_once "./conexion.php";
    
    $sql_name = "list";
    $query = "SELECT sql_instruccion FROM sql_table WHERE sql_name = :sql_name";
    
    $stmt = $objetoConexionDb->prepare($query);
    $stmt->bindParam(':sql_name', $sql_name, PDO::PARAM_STR);
    $stmt->execute();

    $query_content = $stmt->fetchColumn();

    // Consulta para obtener los datos
    $sql = $query_content;
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
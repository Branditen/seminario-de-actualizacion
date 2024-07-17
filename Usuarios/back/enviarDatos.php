<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" ) 
    {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $celular = $_POST['celular'];
        if ($nombre != "" && $apellido != "" && $email != "" && $celular != ""){
            try {
                require_once "./conexion.php";

                $sql_name = "insert";
                $query = "SELECT sql_instruccion FROM sql_table WHERE sql_name = :sql_name";
                
                $stmt = $objetoConexionDb->prepare($query);
                $stmt->bindParam(':sql_name', $sql_name, PDO::PARAM_STR);
                $stmt->execute();

                $query_content = $stmt->fetchColumn();
                
                //Inserta en la base de datos osoDb, en los atributos nombre, apellido, email,celular los valores que estan en las variables $nombre,$apellido, $email,$celular
                //Preparo la base de datos para evitar inyecciones SQL
                $query2 = $query_content;

                //Creo la variable stmt de statement
                $stmt2 = $objetoConexionDb->prepare($query2);

                //En esta fase agrego a la base de datos los datos que el usario ingreso por medio del forumulario HTML
                $stmt2->execute([$nombre,$apellido,$email,$celular]);

                $objetoConexionDb = null;
                $stmt = null;
                $stmt2 = null;
                
                header("Location: ../front/index.html");
                die();

            } catch (PDOException $error) {
                die("La consulta a la base de datos fallo: " . $error->getMessage());
            }
        } else {
            header("Location: ../front/index.html");
            
        }
    }
    else
    {
        header("Location: ../front/index.html");
    }

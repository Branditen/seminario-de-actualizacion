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

                //Inserta en la base de datos osoDb, en los atributos nombre, apellido, email,celular los valores que estan en las variables $nombre,$apellido, $email,$celular
                //Preparo la base de datos para evitar inyecciones SQL
                $consulta ="INSERT INTO user(nombre,apellido,email,celular) VALUES (?,?,?,?);";

                //Creo la variable stmt de statement
                $stmt = $objetoConexionDb->prepare($consulta);

                //En esta fase agrego a la base de datos los datos que el usario ingreso por medio del forumulario HTML
                $stmt->execute([$nombre,$apellido,$email,$celular]);

                $objetoConexionDb = null;
                $stmt = null;
                
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

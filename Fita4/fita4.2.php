<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fita3.1</title>
</head>

<body>


    <?php

    # (1.1) Connectem a MySQL (host,usuari,contrassenya)
    $conn = mysqli_connect('localhost', 'admin', 'Admin@123');

    # (1.2) Triem la base de dades amb la que treballarem
    mysqli_select_db($conn, 'world');

    # (2.1) creem el string de la consulta (query)
    $consulta = "SELECT distinct Continent FROM country;";

    # (2.2) enviem la query al SGBD per obtenir el resultat
    $resultat = mysqli_query($conn, $consulta);

    # (2.3) si no hi ha resultat (0 files o bé hi ha algun error a la sintaxi)
#     posem un missatge d'error i acabem (die) l'execució de la pàgina web
    if (!$resultat) {
        $message = 'Consulta invàlida: ' . mysqli_error($conn) . "\n";
        $message .= 'Consulta realitzada: ' . $consulta;
        die($message);
    }
    ?>


    <form method="post" action="">



        <?php

        while ($registre = mysqli_fetch_assoc($resultat)) {
            $continent = $registre["Continent"];
            echo "<input type='checkbox' name='options[]' value='$continent'> $continent<br>";

        }


        ?>


        <input type="submit">
    </form>


    <?php


    if (isset($_POST["options"])) {
        // Obtener los continentes seleccionados
        $paises = "'" . implode("','", $_POST["options"]) . "'";  // Formatear los valores de la consulta
        echo $paises;
        // (2.1) Crear el string de la consulta
        $consulta = "SELECT Name FROM country WHERE Continent IN ($paises);";  // Usar paréntesis alrededor de $paises
    
        // (2.2) Enviar la consulta al SGBD para obtener el resultado
        $resultat = mysqli_query($conn, $consulta);

        // Mostrar los resultados
        echo "<ul>";
        while ($registre = mysqli_fetch_assoc($resultat)) {
            $pais = $registre["Name"];
            echo "<li>$pais</li>";
        }
        echo "</ul>";
    }
    ?>







</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fita3.1</title>
</head>

<body>


    <?php


    if (isset($_POST["language"])) {


        # (1.1) Connectem a MySQL (host,usuari,contrassenya)
        $conn = mysqli_connect('localhost', 'admin', 'Admin@123');

        # (1.2) Triem la base de dades amb la que treballarem
        mysqli_select_db($conn, 'world');

        # (2.1) creem el string de la consulta (query)
        $consulta = "SELECT distinct Language, isOfficial FROM countrylanguage";

        # (2.2) enviem la query al SGBD per obtenir el resultat
        $resultat = mysqli_query($conn, $consulta);

        # (2.3) si no hi ha resultat (0 files o bé hi ha algun error a la sintaxi)
#     posem un missatge d'error i acabem (die) l'execució de la pàgina web
        if (!$resultat) {
            $message = 'Consulta invàlida: ' . mysqli_error($conn) . "\n";
            $message .= 'Consulta realitzada: ' . $consulta;
            die($message);
        }

    }




    ?>


    <form method="post" action="">
        <label for="language">Language:
        </label>
        <input type="text" name="language" id="language">
        <input type="submit">
    </form>


    <?php

    if (isset($_POST["language"])) {

        $language = $_POST["language"];


        echo "<ul>";
        # (3.2) Bucle while
        while ($registre = mysqli_fetch_assoc($resultat)) {
            # els \t (tabulador) i els \n (salt de línia) son perquè el codi font quedi llegible
            if (str_contains($registre["Language"], $language) || str_contains($registre["Language"], ucfirst($language))) {


                # (3.4) cadascuna de les columnes ha d'anar precedida d'un <td>
                #	després concatenar el contingut del camp del registre
                #	i tancar amb un </td>
                if ($registre["isOfficial"] === "T") {

                    echo "\t\t<li>" . $registre["Language"] . "[Official]" . "</li>\n";
                } else {
                    echo "\t\t<li>" . $registre["Language"] . "</li>\n";
                }



            }
        }

        echo "</ul>";
    }
    ?>
    <!-- (3.6) tanquem la taula -->







</body>

</html>
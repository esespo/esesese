<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Grzybobranie</title>
    <link rel="stylesheet" href="styl5.css">
</head>
<body>

    <section id="miniatury">
        <a href="borowik.jpg">
            <img src="borowik-miniatura.jpg" alt="Grzybobranie">
        </a>
    </section>

    <section id="tytulowy">
        <h1>Idziemy na grzyby!</h1>
    </section>

    <section id="lewy">
        <?php

        $conn = mysqli_connect("localhost", "root", "", "dane2");

        $zapytanie3 = "SELECT nazwa_pliku, potoczna FROM grzyby";
        $wynik = mysqli_query($conn, $zapytanie3);

        while ($row = mysqli_fetch_row($wynik)) {
            echo '<img src="' . $row[0] . '" title="' . $row[1] . '">';
        }

        mysqli_close($conn);
        ?>
    </section>

    <section id="prawy">
        <h2>Grzyby jadalne</h2>

        <?php

        $conn = mysqli_connect("localhost", "root", "", "dane2");

        $zapytanie2 = "
            SELECT g.nazwa, g.potoczna, r.potoczna 
            FROM grzyby g
            JOIN rodzina r ON g.rodzina_id = r.id
            JOIN potrawy p ON g.potrawa_id = p.id
            WHERE p.nazwa = 'sos';
        ";

        $wynik2 = mysqli_query($conn, $zapytanie2);

        while ($row2 = mysqli_fetch_row($wynik2)) {
            echo "<p>$row2[0] ($row2[1])</p>";
        }

        mysqli_close($conn);
        ?>

        <h2>Polecamy do sosów</h2>

        <?php

        $conn = mysqli_connect("localhost", "root", "", "dane2");

        $wynik3 = mysqli_query($conn, $zapytanie2);

        echo "<ol>";
        while ($row3 = mysqli_fetch_row($wynik3)) {
            echo "<li>$row3[0] ($row3[1]), rodzina: $row3[2]</li>";
        }
        echo "</ol>";

        mysqli_close($conn);
        ?>
    </section>

    <section id="stopka">
        <p>Autor: Weronika Kozłowska</p>
    </section>

</body>
</html>
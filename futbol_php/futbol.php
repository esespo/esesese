<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rozgrywki futbolowe</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>
    <header>
        <h2>Światowe Rozgrywki piłkarskie</h2>
        <img src="obraz1.jpg" alt="boisko">
    </header>
    <section id="blok">
    <?php
    $conn = mysqli_connect("localhost", "root", "", "egzamin1");
    $zap1 = "SELECT zespol1, zespol2, wynik, data_rozgrywki FROM `rozgrywka` WHERE zespol1 = 'EVG';";
    $result = $conn->query($zap1);
    
    while ($row = $result->fetch_assoc()) {
        $zespol1 = $row['zespol1'];
        $zespol2 = $row['zespol2'];
        $wynik = $row['wynik'];
        echo"<section id='mecze'>";
        $data_rozgrywki = $row['data_rozgrywki'];
        echo"<h3>$zespol1 - $zespol2</h3>";
        echo"<h4>$wynik</h4>";
        echo"<p>w dniu: $data_rozgrywki</p>";
        echo"</section>";
    }
  
    ?>
    </section>
    <main>
        <h2>Reprezentacja Polski</h2>
    </main>
    <section id="left">
        <p>Podaj pozycję zawodników (1-bramkarze, 2-obrońcy, 3-pomocnicy, 
4-napastnicy):</p>
<form action="futbol.php" method="post">
    <input type="number" name="pozycja" id="pozycja">
    <button type="submit" name="sprawdz">Sprawdź</button>  
    <ul>
        <?php
        if (isset($_POST['sprawdz'])) {
            $pozycja = $_POST['pozycja'];
            $zap2 = "SELECT imie, nazwisko FROM `zawodnik` WHERE pozycja_id = '$pozycja';";
                $result = $conn->query($zap2);
            while ($row = $result->fetch_assoc()) {
                $imie = $row['imie'];
                $nazwisko = $row['nazwisko'];               
                echo"<li><p>$imie $nazwisko</p></li>";               
            }
        };

        mysqli_close($conn);
        ?>
    </ul>
</form>
    </section>
    <section id="right">
        <img src="zad1.png" alt="piłkarz">
        <p>Autor: 000000000000</p>
    </section>
</body>
</html>
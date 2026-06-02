<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Kalendarz</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>
    <header>
        <h1> Dni, miesiące, lata...</h1>
    </header>

    <section id="bloknapisu">
         <p>Dzisiaj jest .....</p>
        </section>

    <section id="lewy"> 
        <table>
            <tr>
                <td> liczba dni </td>
                <td> miesiąc </td>
            </tr>
           <tr>
  <td rowspan="7">31</td>
  <td>styczeń</td>
</tr>
<tr><td>marzec</td></tr>
<tr><td>maj</td></tr>
<tr><td>lipiec</td></tr>
<tr><td>sierpień</td></tr>
<tr><td>październik</td></tr>
<tr><td>grudzień</td></tr>

<tr>
  <td rowspan="4">30</td>
  <td>kwiecień</td>
</tr>
<tr><td>czerwiec</td></tr>
<tr><td>wrzesień</td></tr>
<tr><td>listopad</td></tr>

<tr>
  <td>28 lub 29</td>
  <td>luty</td>
</tr>

</table>  

    </section>

    <section id="środkowy">
    <h2> Sprawdź kto ma urodziny </h2>
    <input type="date" id="data" min="2024-01-01" max="2024-12-31">
    <input type="button" id="przycisk" value="wyślij">

    </section>

    <section class="prawy">
        <a href="https://pl.wikipedia.org/wiki/Kalendarz_Majów"><img src="kalendarz.gif" alt="Kalendarz Majów"></a>
        <h2>Rodzaje kalendarzy</h2>
        <ol>
            <li>słoneczny</li>
            <ul>
                <li>kalendarz Majów</li>
                <li>juliański</li>
                <li>gregoriański</li>
            </ul>
            <li>księżycowy</li>
                <ul>
                <li>starogrecki</li>
                <li>balbiloński</li>
            </ul>
        </ol>
    </section>


    <footer>
        <p>Stronę opracował: 0000000000</p>
    </footer>

    <script>
    document.getElementById("przycisk").addEventListener("click", function() {
        var data = document.getElementById("data").value;
        var dzien = new Date(data).getDate();
        var miesiac = new Date(data).getMonth() + 1;
        var rok = new Date(data).getFullYear();

        var urodziny = {
            "1-1": "Nowy Rok",
            "14-2": "Walentynki",
            "17-3": "Dzień Świętego Patryka",
            "1-4": "Prima Aprilis",
            "1-5": "Święto Pracy",
            "31-10": "Halloween",
            "25-12": "Boże Narodzenie"
        };

        var klucz = dzien + "-" + miesiac;
        if (urodziny[klucz]) {
            alert("W dniu " + data + " obchodzimy: " + urodziny[klucz]);
        } else {
            alert("W dniu " + data + " nie ma żadnych znanych świąt.");
        }
    });

    </script>
</body>
</html>
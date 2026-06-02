<?php
$polaczenie = new mysqli('localhost', 'root', '', 'portal');

if ($polaczenie->connect_error) {
    die('Błąd połączenia z bazą: ' . $polaczenie->connect_error);
}

$liczba_uzytkownikow = 0;
$wynik_licznika = $polaczenie->query('SELECT COUNT(*) AS liczba_wierszy FROM dane');
if ($wynik_licznika && $wiersz_licznika = $wynik_licznika->fetch_assoc()) {
    $liczba_uzytkownikow = (int)$wiersz_licznika['liczba_wierszy'];
}

$komunikat = '';
$profil = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $haslo = trim($_POST['haslo'] ?? '');

    if ($login !== '' && $haslo !== '') {
        $zapytanie_login = $polaczenie->prepare('SELECT haslo FROM uzytkownicy WHERE login = ?');
        $zapytanie_login->bind_param('s', $login);
        $zapytanie_login->execute();
        $rezultat_login = $zapytanie_login->get_result();

        if ($rezultat_login->num_rows === 0) {
            $komunikat = 'login nie istnieje';
        } else {
            $rekord = $rezultat_login->fetch_assoc();
            $haslo_sha1 = sha1($haslo);

            if (!hash_equals($rekord['haslo'], $haslo_sha1)) {
                $komunikat = 'hasło nieprawidłowe';
            } else {
                $zdjecia_po_login = [
                    'Janek' => '05.jpg',
                ];

                $sprawdz_login = $polaczenie->query("SHOW COLUMNS FROM dane LIKE 'login'");
                if ($sprawdz_login && $sprawdz_login->num_rows > 0) {
                    $zapytanie_profil = $polaczenie->prepare('SELECT rok_urodz, hobby, przyjaciol, zdjecie FROM dane WHERE login = ? ORDER BY id LIMIT 1');
                    $zapytanie_profil->bind_param('s', $login);
                } else {
                    $zapytanie_profil = $polaczenie->prepare('SELECT rok_urodz, hobby, przyjaciol, zdjecie FROM dane ORDER BY id LIMIT 1');
                }

                if (isset($sprawdz_login)) {
                    $sprawdz_login->close();
                }

                $zapytanie_profil->execute();
                $rezultat_profil = $zapytanie_profil->get_result();
                $profil = $rezultat_profil->fetch_assoc();
                if ($profil !== null) {
                    $profil['login'] = $login;
                    if (isset($zdjecia_po_login[$login])) {
                        $profil['zdjecie'] = $zdjecia_po_login[$login];
                    }
                }
            }
        }

        $zapytanie_login->close();
        if (isset($zapytanie_profil)) {
            $zapytanie_profil->close();
        }
    }
}

$polaczenie->close();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal społecznościowy</title>
    <link rel="stylesheet" href="styl5.css">
</head>
<body>
    <header>
        <section id="banerlewy">
            <h2>Nasze osiedle</h2>
        </section>
        <section id="banerprawy">
            <h5>Liczba użytkowników portalu: <?php echo $liczba_uzytkownikow; ?></h5>
        </section>
    </header>
    <section class="lewy">
        <h3>Logowanie</h3>
        <form method="post" action="">
            login <br>
            <input type="text" name="login" value="<?php echo isset($_POST['login']) ? htmlspecialchars($_POST['login'], ENT_QUOTES, 'UTF-8') : ''; ?>"> <br>
            hasło <br>
            <input type="password" name="haslo"> <br>
            <input type="submit" value="Zaloguj">
        </form>

        <?php if ($komunikat !== ''): ?>
            <p><?php echo htmlspecialchars($komunikat, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
    </section>

    <section class="prawy">
        <h3>Wizytówka</h3>

        <?php if ($profil !== null): ?>
            <table class="wizytowka">
                <tr>
                    <td colspan="2">
                        <img src="<?php echo htmlspecialchars($profil['zdjecie'], ENT_QUOTES, 'UTF-8'); ?>" alt="osoba">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <h4><?php echo htmlspecialchars($profil['login'], ENT_QUOTES, 'UTF-8'); ?> (<?php echo (int)(date('Y') - (int)$profil['rok_urodz']); ?>)</h4>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p>hobby: <?php echo htmlspecialchars($profil['hobby'], ENT_QUOTES, 'UTF-8'); ?></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="liczba-przyjaciol">
                            <img src="icon-on.png" alt="serce">
                            <p><?php echo htmlspecialchars($profil['przyjaciol'], ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <a href="dane.html"><button type="button" class="przycisk-wiecej">Więcej informacji</button></a>
                    </td>
                </tr>
            </table>
        <?php endif; ?>
    </section>

    <footer>
        <p>Autor: 000000000000000</p>
    </footer>
    
</body>
</html>
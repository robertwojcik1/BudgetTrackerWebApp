<?php

session_start();

if (!isset($_SESSION['registration_success'])) {
    header('Location: index.php');
    exit();
} else {
    unset($_SESSION['registration_success']);
}

if (isset($_SESSION['fr_name'])) unset($_SESSION['fr_name']);
if (isset($_SESSION['fr_email'])) unset($_SESSION['fr_email']);
if (isset($_SESSION['fr_password1'])) unset($_SESSION['fr_password1']);
if (isset($_SESSION['fr_password2'])) unset($_SESSION['fr_password2']);

if (isset($_SESSION['e_name'])) unset($_SESSION['e_name']);
if (isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
if (isset($_SESSION['e_password'])) unset($_SESSION['e_password']);

?>

<!DOCTYPE HTML>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <title>Aplikacja budżetowa MyBudget</title>

    <meta name="description" content="Aplikacja do zarządzania budżetem osobistym" />
    <meta name="keywords" content="budżet, przychody, wydatki" />

    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">

</head>

<body>

    <header>
        <div id="logo"><a href="index.php">MyBudget.pl</a></div>
        <div id="sentence">
            <figure>
                <blockquote class="blockquote text-center">
                    <p>Nawyk zarządzania pieniędzmi jest ważniejszy niż ilość posiadanych pieniędzy.</p>
                </blockquote>
                <figcaption class="blockquote-footer text-center">
                    <cite title="Source Title">T. HARV EKER</cite>
                </figcaption>
            </figure>
        </div>
    </header>

    <main>
        <section>
            <div class="container" style="width: 400px">
                Dziękujemy za rejestrację w serwisie! Możesz już zalogować się na swoje konto!<br /><br />

                <a href="index.php">Zaloguj się na swoje konto!</a>
                <br /><br />
            </div>
        </section>

        <footer>
            <div id="footer">&copy; 2022 MyBudget.pl</div>
        </footer>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
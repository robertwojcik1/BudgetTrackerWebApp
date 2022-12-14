<?php

session_start();

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
    exit();
} else {
    require_once "connect.php";
    $connect = new mysqli($host, $db_user, $db_password, $db_name);

    $userId = $_SESSION['user_id'];
    $date1 = '2022-12-01';
    $date2 = '2022-12-31';

    $getIncomeCategoryName = $connect->query("SELECT name
    FROM incomes_category_assigned_to_users
    WHERE user_id='$userId'");

    $getExpenseCategoryName = $connect->query("SELECT name
    FROM expenses_category_assigned_to_users
    WHERE user_id='$userId'");

    $totalIncomeSum = $connect->query("SELECT SUM(amount)
    FROM incomes
    WHERE user_id='$userId' AND date_of_income BETWEEN '$date1' AND '$date2'");
    $total = $totalIncomeSum->fetch_column();
}

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

    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="main-menu.php">Menu główne</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="add-income.php">Dodaj przychód</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add-expense.php">Dodaj wydatek</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="balance.php">Przeglądaj bilans</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="settings.php">Ustawienia</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Wyloguj</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header>
        <div id="logo"><a href="main-menu.php">MyBudget.pl</a></div>
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
            <div class="container" style="width: 1200px">
                <h1><em>Bilans z wybranego okresu</em></h1>
                <form>
                    <div class="dateRange">
                        <select class="form-select" aria-label="Default select example">
                            <option selected>Wybierz przedział czasowy</option>
                            <option value="1">Bieżący miesiąc</option>
                            <option value="2">Poprzedni miesiąc</option>
                            <option value="3">Bieżący rok</option>
                            <option value="4" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                data-bs-whatever="@mdo">Niestandardowy</option>
                        </select>
                    </div>
                </form>

                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Wybierz zakres dat</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="mb-3">
                                        <label class="col-form-label">Data początkowa:</label>
                                        <input type="date" class="form-control" id="begin-date">
                                    </div>
                                    <div class="mb-3">
                                        <label class="col-form-label">Data końcowa:</label>
                                        <input type="date" class="form-control" id="end-date">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
                                <button type="button" class="btn btn-primary">Zatwierdź</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="window">
                    <h2>Przychody</h2>
                    <?php
                                            while ($name = $getIncomeCategoryName ->fetch_column())
                                            {
                        echo $name . "<br>" . $total;       
                                            }
                                        ?>
                </div>

                <div class="window">
                    <h2> Wydatki </h2>
                    <ul>
                        <li> Jedzenie: 500 <br /> data 12-03-2022 </li>
                        <li> Opieka zdrowotna: 300 <br /> data 03-04-2022, komentarz: dentysta </li>
                        <li> Rozrywka: 100 <br /> data 05-06-2022, komentarz: kino </li>
                    </ul>
                    <b>Suma wydatków: 900</b>
                </div>

                <div class="balance">
                    <h2> Bilans </h2>
                    <b> 5450 </b> <br />
                    Gratulacje! Świetnie zarządzasz swoim budżetem.
                </div>

                <div class="chart">
                    (miejsce na diagram kołowy)
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div id="footer">&copy; 2022 MyBudget.pl</div>
    </footer>



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
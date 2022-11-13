<?php

session_start();

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
    exit();
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
			  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
					<a class="nav-link" href="#">Ustawienia</a>
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
			<div class="container" style="width: 400px">
				<br><br><h1><em>Dodaj przychód</em></h1>
				<form action="income.php" method="post">

					<div class="input-group mb-3">
						<div><label for="amount"><input type="number" class="form-control" placeholder="Kwota" id="amount" name="amount" step="0.01" min="0"
									max="1000000" required
									aria-label="Cash amount (with dot and two decimal places)"></label></div>
					</div>

					<div class="input-group mb-3">
						<div><label for="datepicker"><input type="date" name="date" class="form-control" id="datepicker" min="2000-01-01" max="2022-12-31"
									required></label></div>
					</div>

					<div class="mb-3">
						Kategoria przychodu
						<select class="form-select" name="category" aria-label="Default select example">
							<option value="1">Wynagrodzenie</option>
							<option value="2">Odsetki bankowe</option>
							<option value="3">Sprzedaż na allegro</option>
							<option value="4">Inne</option>
						</select>
					</div>

					<div class="mb-3">
						<label for="comment"><textarea class="form-control" id="comment" name="comment"
								placeholder="Komentarz (opcjonalnie)" maxlength="150" rows="3"
								cols="35"></textarea></label>
					</div>
					<div class="form-check">
						<label for="submit"><button type="submit" class="btn btn-success" id="submit">Dodaj</button></label>
					</div>
					<div class="form-check">
						<label for="cancel"><a class="btn btn-secondary" href="main-menu.html" role="button" id="cancel">Anuluj</a></label>
					</div>
				</form>
			</div>

		</section>

		<footer>
			<div id="footer">&copy; 2022 MyBudget.pl</div>
		</footer>

	</main>

	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
		integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB"
		crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
		integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
		crossorigin="anonymous"></script>
	<script src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/today.js"></script>

</body>

</html>
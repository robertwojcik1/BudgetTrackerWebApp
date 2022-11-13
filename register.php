<?php

session_start();

if (isset($_POST['email'])) {
	$all_fine = true;

	$name = $_POST['name'];

	if ((strlen($name) < 3) || (strlen($name) > 20)) {
		$all_fine = false;
		$_SESSION['e_name'] = "Imię musi posiadać od 3 do 20 znaków!";
	}

	if (!ctype_alnum($name)) {
		$all_fine = false;
		$_SESSION['e_name'] = "Imię może składać się tylko z liter i cyfr (bez polskich znaków)";
	}

	$email = $_POST['email'];
	$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);

	if ((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB != $email)) {
		$all_fine = false;
		$_SESSION['e_email'] = "Podaj poprawny adres e-mail!";
	}

	$password1 = $_POST['password1'];
	$password2 = $_POST['password2'];

	if ((strlen($password1) < 8) || (strlen($password1) > 20)) {
		$all_fine = false;
		$_SESSION['e_password'] = "Hasło musi posiadać od 8 do 20 znaków!";
	}

	if ($password1 != $password2) {
		$all_fine = false;
		$_SESSION['e_password'] = "Podane hasła nie są identyczne!";
	}

	$password_hash = password_hash($password1, PASSWORD_DEFAULT);

	$_SESSION['fr_name'] = $name;
	$_SESSION['fr_email'] = $email;
	$_SESSION['fr_password1'] = $password1;
	$_SESSION['fr_password2'] = $password2;

	require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);

	try {
		$connect = new mysqli($host, $db_user, $db_password, $db_name);
		if ($connect->connect_errno != 0) {
			throw new Exception(mysqli_connect_errno());
		} else {
			$result = $connect->query("SELECT id FROM users WHERE email='$email'");

			if (!$result) throw new Exception($connect->error);

			$how_many_emails = $result->num_rows;
			if ($how_many_emails > 0) {
				$all_fine = false;
				$_SESSION['e_email'] = "Istnieje już konto przypisane do tego adresu e-mail!";
			}

			if ($all_fine) {

				if ($connect->query("INSERT INTO users VALUES (NULL, '$name', '$password_hash', '$email')")) {
					$_SESSION['registration_success'] = true;

                    /*assigning default expenses categories to new user*/
                    $registered_user_id = $connect->insert_id;
                    $connect->query("INSERT INTO expenses_category_assigned_to_users (user_id, name) SELECT '$registered_user_id' AS user_id, name FROM expenses_category_default;");
                    $connect->query("SET @max_id = (SELECT MAX(id) FROM expenses_category_assigned_to_users) + 1;");
                    $connect->query("#SELECT @max_id;");
                    $connect->query("SET @sql = CONCAT('ALTER TABLE `expenses_category_assigned_to_users` AUTO_INCREMENT = ', @max_id);");
                    $connect->query("PREPARE stmt FROM @sql;");
                    $connect->query("EXECUTE stmt;");

                    /*assigning default incomes categories to new user*/
                    $connect->query("INSERT INTO incomes_category_assigned_to_users (user_id, name) SELECT '$registered_user_id' AS user_id, name FROM incomes_category_default;");
                    $connect->query("SET @max_id = (SELECT MAX(id) FROM incomes_category_assigned_to_users) + 1;");
                    $connect->query("#SELECT @max_id;");
                    $connect->query("SET @sql = CONCAT('ALTER TABLE `incomes_category_assigned_to_users` AUTO_INCREMENT = ', @max_id);");
                    $connect->query("PREPARE stmt FROM @sql;");
                    $connect->query("EXECUTE stmt;");

                    /*assigning default payment methods to new user*/
                    $connect->query("INSERT INTO payment_methods_assigned_to_users (user_id, name) SELECT '$registered_user_id' AS user_id, name FROM payment_methods_default;");
                    $connect->query("SET @max_id = (SELECT MAX(id) FROM payment_methods_assigned_to_users) + 1;");
                    $connect->query("#SELECT @max_id;");
                    $connect->query("SET @sql = CONCAT('ALTER TABLE `payment_methods_assigned_to_users` AUTO_INCREMENT = ', @max_id);");
                    $connect->query("PREPARE stmt FROM @sql;");
                    $connect->query("EXECUTE stmt;");
                    
					header('Location: welcome.php');
				} else {
					throw new Exception($connect->error);
				}
			}

			$connect->close();
		}
	} catch (Exception $e) {
		echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
	}
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
            <div class="container" style="width: 800px">
                <div class="center">
                    <h1><em>Rejestracja</em></h1>
                    <form method="post">
                        <div class="mb-3">
                            <label for="name">Imię </label>
                            <input class="form-control" type="text" name="name" id="name" value=""
                                aria-label="podaj imię" required>
                        </div>

                        <?php
						if (isset($_SESSION['e_name'])) {
							echo '<div class="error">' . $_SESSION['e_name'] . '</div>';
							unset($_SESSION['e_name']);
						}
						?>

                        <div class="mb-3">
                            <label for="email">E-mail </label>
                            <input type="email" class="form-control" name="email" value="" id="email" required>
                        </div>
                        <?php
						if (isset($_SESSION['e_email'])) {
							echo '<div class="error">' . $_SESSION['e_email'] . '</div>';
							unset($_SESSION['e_email']);
						}
						?>
                        <div class="mb-3">
                            <label for="password1">Hasło</label>
                            <input type="password" class="form-control" name="password1" value="" id="password1"
                                required>
                        </div>
                        <?php
						if (isset($_SESSION['e_password'])) {
							echo '<div class="error">' . $_SESSION['e_password'] . '</div>';
							unset($_SESSION['e_password']);
						}
						?>
                        <div class="mb-3">
                            <label for="password2">Powtórz hasło</label>
                            <input type="password" class="form-control" name="password2" value="" id="password2"
                                required>
                        </div>
                        <label><button type="submit" class="btn btn-success">Załóz konto</button></label><br><br>
                    </form>
                    <div>
                        <label><a class="btn btn-secondary" href="index.php" role="button">Anuluj</a></label>
                    </div>
                </div>
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
<?php

	session_start();

    if ((!isset($_POST['login'])) || (!isset($_POST['password'])))
	{
		header('Location: index.php');
		exit();
	}

    require_once "connect.php";

    $connect = @new mysqli($host, $db_user, $db_password, $db_name);

    if ($connect -> connect_errno!=0)
	{
		echo "Error: ".$connect -> connect_errno;
	}
    else
	{
		$login = $_POST['login'];
		$password = $_POST['password'];
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		$password = htmlentities($password, ENT_QUOTES, "UTF-8");

        if ($result = @$connect->query(
            sprintf("SELECT * FROM users WHERE email='%s' AND password='%s'",
            mysqli_real_escape_string($connect,$login),
            mysqli_real_escape_string($connect,$password))))
            {
                $how_many_users = $result -> num_rows;
                if($how_many_users > 0)
                {
                    $_SESSION['logged'] = true;
                    
                    $row = $result -> fetch_assoc();
                    $_SESSION['login'] = $row['login'];
                    $_SESSION['password'] = $row['password'];
                    
                    unset($_SESSION['error']);
                    $result -> free_result();
                    header('Location: main-menu.php');
                    
                } else {
                    $_SESSION['error'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
				    header('Location: index.php');
			}
		}
		$connect -> close();
	}
?>
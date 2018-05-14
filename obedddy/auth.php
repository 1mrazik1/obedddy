<?php
session_start();

//$currentUser = null;
$user = [];
$currentBalance = selectUserBalance($_SESSION['userId']) ?? 0;

function authentificate() {
	if (isset($_POST['logout'])) {
		unset($_SESSION['userId']);
		session_destroy();
		return '<div class="alert alert-primary" role="alert">Úspešne odhlásený!</div>';
	} elseif (isset($_POST['action']) && $_POST['action'] === 'login') {
		$user = selectUserByUsername($_POST['username']);

		if (!password_verify($_POST['password'], $user['password'])) {
			return '<div class="alert alert-danger" role="alert">Zlé meno alebo heslo!</div>';
		}
		//$currentUser = $user['id'];
		$_SESSION['userId'] = $user['id'];
		$currentBalance = selectUserBalance($_SESSION['userId']);
	}
}

function isLoggedIn()
{
	return isset($_SESSION['userId']);
}
<?php
include '../root/config.php';
include '../auth/UserRegistration.php';

$userRegistration = new UserRegistration($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($password === $confirmPassword) {
        $userRegistration->registerUser($username, $password);
    } else {
        echo 'Errore: La password e la conferma della password non corrispondono.';
    }
}

include '../auth/register_layout.php';
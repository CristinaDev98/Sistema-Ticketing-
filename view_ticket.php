<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo 'Non sei autorizzato a visualizzare questa pagina.';
    exit();
}

$userId = $_SESSION['user_id'];

$conn = new mysqli('localhost', 'root', '', 'sistema_ticketing');

if ($conn->connect_error) {
    die('Connessione al database fallita: ' . $conn->connect_error);
}

$queryTicketUtente = "SELECT * FROM ticket WHERE user_id = '$userId'";
$resultTicket = $conn->query($queryTicketUtente);

if (!$resultTicket) {
    die('Errore nella query: ' . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Ticketing</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: #5ac66c;
            color: white;
            height: 5em;
            width: 100%;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }

        .card {
            background-color: #fff;
            color: #5ac66c;
            padding: 10px;
            margin: 30px 40px 30px;
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
            border-radius: 8px;
            text-align: center;
        }

        .n-ticket{
            color: #5ac66c;
        }

        .card-ticket {
            background-color: #fff;
            padding: 10px;
            margin: 30px 40px 30px;
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
            border-radius: 8px;
            text-align: center;
        }

        .card:hover,.card-ticket:hover{
            transform: scale(1.05);
        }

        .title-dash {
            text-align: center;
            margin-top: 2em;
            margin-bottom: 2em;
        }

        .title-nav {
            margin-top: -2px;
            margin-left: 1em;
            float: left;
        }

        .name-user {
            float: right;
            margin-top: 10px;
            margin-right: 2em;

        }
        .home-link {
            float: right;
            margin-top: 10px;
            margin-right: 2em;
            cursor: pointer;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <div class="container">
            <h1 class="title-nav">Sistema Ticketing</h1>
            <h3 class="home-link" onclick="location.href='dashboard.php'">Home</h3>
        </div>
    </div>

    <div class="container">
            <h1 class="title-dash">I tuoi ticket</h1>
            <?php
            foreach ($resultTicket as $ticket) {
                echo '<div class="card-ticket">';
                echo '<h2 class="n-ticket">Ticket #' . $ticket['id'] . '</h2>';
                echo '<p>' . $ticket['message'] . '</p>';
                echo '<p>Data creazione: ' . $ticket['created_at'] . '</p>';
                echo '</div>';
            }
            ?>
    </div>
</body>

</html>

<?php
$conn->close();
?>
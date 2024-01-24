<?php
include '../root/config.php';

class TicketUser {
     private $conn;

     public function __construct(mysqli $conn)
     {
         $this->conn = $conn;
     }

    public function checkAuthorization()
    {
        if (!isset($_SESSION['user_id'])) {
            echo 'Non sei autorizzato a visualizzare questa pagina.';
            exit();
        }
    }

    public function deleteTicket()
    {
        $this->checkAuthorization();

        $userId = $_SESSION['user_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_ticket'])) {
            $ticketIdToDelete = $_POST['delete_ticket'];

            $queryDeleteTicket = "DELETE FROM ticket WHERE user_id = '$userId' AND id = '$ticketIdToDelete'";
            if ($this->conn->query($queryDeleteTicket) === true) {
                echo '<script>alert("Ticket eliminato con successo!"); window.location.href = "dashboard.php";</script>';
            } else {
                echo '<script>alert("Errore durante l\'eliminazione del ticket: ' . $this->conn->error . '");</script>';
            }
        }
    }

    public function getTickets()
    {
        $this->checkAuthorization();

        $userId = $_SESSION['user_id'];

        $queryTicketUtente = "SELECT * FROM ticket WHERE user_id = '$userId'";
        $resultTicket = $this->conn->query($queryTicketUtente);

        if (!$resultTicket) {
            die('Errore nella query: ' . $this->conn->error);
        }

        return $resultTicket;
    }

    public function closeConnection()
    {
        $this->conn->close();
    }
}

$ticketUser = new TicketUser($conn);

$ticketUser->deleteTicket();
$resultTicket = $ticketUser->getTickets();
$ticketUser->closeConnection();
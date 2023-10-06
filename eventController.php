<?php

class EventController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function aggiungiEvento(Event $evento) {
        $nome_evento = $evento->getNomeEvento();
        $attendees = $evento->getAttendees();
        $data_evento = $evento->getDataEvento();
        
        $stmt = $this->conn->prepare("INSERT INTO eventi (nome_evento, attendees, data_evento) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome_evento, $attendees, $data_evento);
        
        if ($stmt->execute()) {
            $stmt->close(); // Chiudi il prepared statement
            return true; // Inserimento riuscito
        } else {
            $stmt->close(); // Chiudi il prepared statement in caso di errore
            throw new Exception("Errore nell'inserimento dell'evento nel database.");
        }
    }
    

    public function getEventi() {
        $sql = "SELECT * FROM eventi";
        $result = $this->conn->query($sql);
        
        $eventi = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $evento = new Event($row['id'], $row['nome_evento'], $row['attendees'], $row['data_evento']);
                $eventi[] = $evento;
            }
            $result->close(); // Chiudi il result set
        }

        return $eventi;
    }

    public function modificaEvento($id_evento, Event $evento) {
        $nome_evento = $evento->getNomeEvento();
        $attendees = $evento->getAttendees();
        $data_evento = $evento->getDataEvento();
        
        $stmt = $this->conn->prepare("UPDATE eventi SET nome_evento = ?, attendees = ?, data_evento = ? WHERE id = ?");
        $stmt->bind_param("sssi", $nome_evento, $attendees, $data_evento, $id_evento);
        
        if ($stmt->execute()) {
            $stmt->close(); // Chiudi il prepared statement
            return true; // Aggiornamento riuscito
        } else {
            $stmt->close(); // Chiudi il prepared statement in caso di errore
            throw new Exception("Errore nell'aggiornamento dell'evento nel database.");
        }
    }
    

    public function eliminaEvento($id_evento) {
        $stmt = $this->conn->prepare("DELETE FROM eventi WHERE id = ?");
        $stmt->bind_param("i", $id_evento);
        
        if ($stmt->execute()) {
            $stmt->close(); // Chiudi il prepared statement
            return true; // Eliminazione riuscita
        } else {
            $stmt->close(); // Chiudi il prepared statement in caso di errore
            throw new Exception("Errore nell'eliminazione dell'evento dal database.");
        }
    }
}
?>

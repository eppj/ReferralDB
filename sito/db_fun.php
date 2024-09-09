<?php 
#Funzione per il log in nel DB
function logInDB( $dbname, $servername= "localhost", $username= "root", $password=""){

    // Crea connessione
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Controlla connessione
    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }
    
    return $conn;
}

#Controlla se il nome utente è già presente all'interno del DB
function srcUser($conn,$nome){

    $sql = "SELECT `Nome` FROM `utente` WHERE `Nome`='$nome'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }


}

#controlla se l'invito generato è già presente
function srcInv_gen($conn,$invito){

    $sql = "SELECT `invito_gen` FROM `utente` WHERE `invito_gen`='$invito'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }


}

#Inserisce l'utente all'interno del database se non è già presente
function insertNewUser($conn,$nome){
    if(srcUser($conn,$nome)){
        return true;
    }
    else{
        do{
            $invito= strtoupper(bin2hex(random_bytes(4)));
        }while(srcInv_gen($conn,$invito));
        $sql = "INSERT INTO `utente` (`Nome`, `invito_gen`, `invito_ric`) VALUES ('$nome', '$invito', NULL)";

        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

}

#Restituisce il codice d'invvito
function codeVision($conn,$nome){

    $sql = "SELECT `invito_gen` FROM `utente` WHERE  `Nome`= '$nome'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row["invito_gen"];
    } else {
        return false;
    }

}

#Conta gli inviti di ogni utente
function contaInviti($conn) {
    $invito = codeVision($conn,$_SESSION["nome"]);
    
    $sql = "SELECT COUNT(*) AS total FROM utente WHERE `invito_ric` = '$invito'";
    
    
    $result = $conn->query($sql);

    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['total'];
    } else {
        return 0; 
    }
}

#Controlla se l'utente ha non ha ricevuto inviti in passato
function srcNULLInv_ric($conn,$nome){

    $sql = "SELECT `Nome`, `invito_ric` FROM `utente` WHERE `Nome`= '$nome' && `invito_ric` IS NULL";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }


}

?>
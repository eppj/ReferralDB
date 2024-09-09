<?php
    include 'db_fun.php';
    // inzio con uno start della sessione, utile per salvare dati importati come ad esempio il nome utente e la scelta
    session_start();
    
    
    $_SESSION["nome"] = (!isset($_SESSION["nome"]))?"KingEppj83":$_SESSION["nome"];
    $_SESSION["nome"] = (isset($_POST["nome"]))?$_POST["nome"]:$_SESSION["nome"];
    $_SESSION["scelta"] = (!isset($_SESSION["scelta"]))?"default":$_SESSION["scelta"];
    $_SESSION["scelta"] = (isset($_POST["scelta"]))?$_POST["scelta"]:$_SESSION["scelta"];

    //avvio la connessione al db
    do{
        $conn= logInDB($dbname= "referral_db");
    }while(is_null($conn));
    //inserisco il nome dell'utente all intenro della funzione per controllare se esiste o meno nel DB
    insertNewUser($conn,$_SESSION["nome"]);
    

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Esempio</title>
    </head>
    <body>
        <!-- 
            form che permette l'inserimento dei dati utente
            e selezionare la funzione da far eseguire 
        -->
        <form action="index.php" method="POST">
            <input type="text" id="nome" name="nome" value="<?php echo $_SESSION["nome"] ?>" ><br>
            <select name="scelta" id="scelta">
                <option value="default">---</option>
                <option value="codeVision">codeVision</option>
                <option value="nUserInvited">nUserInvited</option>
                <option value="codeRegistration">codeRegistration</option>
            </select><br>
            <input type="submit" value="Invia">
        </form>
        <!-- 
            Utilizzo uno switch per verificare la scelta dell'utente
            richiamando le funzioni in db_fun.php
        -->
        <?php
            switch ($_SESSION["scelta"]) {
                case "codeVision":
                    $invito= codeVision($conn,$_SESSION["nome"]);
                    echo "Il tuo codice è: [$invito]";
                  break;
                case "nUserInvited":
                    $total= contaInviti($conn);
                    echo "Il tuo codice è stato inserito da: $total utente/i";
                  break;
                case "codeRegistration":
                    if(isset($_POST["invito_ric"])){
                        $invito_ric= $_POST["invito_ric"];
                        $nome= $_SESSION["nome"];
                
                        if(srcNULLInv_ric($conn,$nome)){
                            if(srcInv_gen($conn,$invito_ric)){
                                if($invito_ric != codeVision($conn,$nome)){
                                    $sql = "UPDATE `utente` SET `invito_ric`= '$invito_ric' WHERE `Nome`= '$nome';";
                
                                    if ($conn->query($sql) === TRUE) {
                                        echo "Sei appena stato invitat* da un'utente";
                                    } else {
                                        return true;
                                    }
                                    
                                }
                                else{
                                    echo "Non puoi inserire il tuo stesso codice";
                                }
                            }
                            else{
                                echo "L'invito non esite";
                            }
                        }
                        else{
                            echo "Sei già stato invitat* in passato";
                        }
                    }
                    echo '<form action="index.php" method="POST">
                            <br><input type="text" id="invito_ric" name="invito_ric" value="" ><br>
                            <input type="submit" value="Invia">
                        </form>';
                  break;
                default:
                    echo "fai una scelta per cambiare pagina";
              }
        ?>
        
        

    </body>
</html>
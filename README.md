---

# Progetto: ReferralDB

## Descrizione
Il progetto implementa un sistema di referral utilizzando PHP e MySQL per la gestione di inviti tra utenti. Gli utenti possono registrarsi, generare codici di invito e tracciare chi ha utilizzato il proprio codice per iscriversi. Le principali funzionalità includono la gestione degli utenti, il tracking degli inviti e l'aggiornamento dei record nel database.

---

## Struttura dei File

### 1. Cartella: **DB**
#### Nome File: `referral_DB.sql`

- **Descrizione**: Dump SQL per la creazione e la gestione della tabella `utente` nel database MySQL.
- **Tabella Principale**: `utente`
  - **Colonne**:
    - `Nome`: Nome dell'utente.
    - `invito_gen`: Codice di invito generato dall'utente.
    - `invito_ric`: Codice di invito utilizzato dall'utente per iscriversi (opzionale).
- **Vincoli**:
  - Chiave univoca su `Nome` e `invito_gen`.
- **Dati di esempio**: Viene fornito un dump di esempio con due utenti e i rispettivi codici di invito.

---

### 2. Cartella: **sito**
#### Nome File: `index.php`

- **Descrizione**: File principale che gestisce l'interazione utente-DB. Permette di inserire il nome utente, selezionare diverse operazioni, e interagire con il database.
- **Funzionalità**:
  - **Sessione utente**: Gestisce le sessioni per memorizzare nome utente e scelte.
  - **Connessione al DB**: Si collega al database `referral_db`.
  - **Form di input**: Un form HTML permette di inserire il nome utente e scegliere l'azione da eseguire (generazione codice, numero di inviti, registrazione codice).
  - **Gestione delle scelte**: Con uno switch in PHP, permette di:
    - **codeVision**: Mostrare il codice di invito generato.
    - **nUserInvited**: Mostrare il numero di utenti che hanno utilizzato il codice di invito dell'utente.
    - **codeRegistration**: Registrare un codice di invito esterno se non è già stato inserito.


#### Nome File: `db_fun.php`

- **Descrizione**: Contiene le funzioni PHP utilizzate per interagire con il database MySQL.
- **Funzioni Principali**:
  1. **logInDB()**: Connessione al database MySQL.
  2. **srcUser()**: Verifica se l'utente esiste già nel database.
  3. **srcInv_gen()**: Controlla se un codice di invito è già presente.
  4. **insertNewUser()**: Inserisce un nuovo utente nel database generando un codice di invito univoco.
  5. **codeVision()**: Restituisce il codice di invito di un utente.
  6. **contaInviti()**: Conta quante persone hanno usato il codice di invito dell'utente.
  7. **srcNULLInv_ric()**: Controlla se l'utente ha già ricevuto un invito in passato.

---

## Utilizzo
1. **Accedi alla pagina principale** (`index.php`) tramite il browser:
   - Inserisci un nome utente e seleziona un'opzione dal menù a tendina:
     - Genera codice di invito
     - Visualizza quanti utenti hanno usato il tuo codice
     - Inserisci un codice di invito esterno

2. **Esegui le operazioni**:
   - Puoi interagire con il database per gestire inviti e utenti.
[![Guarda il Video](https://img.youtube.com/vi/qcCLijHd-98/maxresdefault.jpg)](https://www.youtube.com/watch?v=qcCLijHd-98)



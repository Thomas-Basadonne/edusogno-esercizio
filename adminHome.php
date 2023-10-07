<?php
    // Includi il file con la definizione delle classi Event e EventController
    require_once('event.php');
    require_once('eventController.php');

    // Connessione al database
    $mysqli = require_once('database.php');

    // Creazione dell'oggetto EventController e passaggio della connessione al database
    $eventController = new EventController($mysqli);

    // Esegui operazioni CRUD in base all'azione selezionata
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'add') {
            // Aggiungi un nuovo evento
            $evento = new Event(null, $_POST['nome_evento'], $_POST['attendees'], $_POST['data_evento']);
            if ($eventController->aggiungiEvento($evento)) {
                echo "Nuovo evento aggiunto con successo.<br>";
            }
        } elseif ($action === 'edit') {
            // Modifica un evento esistente
            $idDaModificare = $_POST['id_evento'];
            $eventoModificato = new Event($idDaModificare, $_POST['nome_evento'], $_POST['attendees'], $_POST['data_evento']);
            if ($eventController->modificaEvento($idDaModificare, $eventoModificato)) {
                echo "Evento modificato con successo.<br>";
            }
        } elseif ($action === 'delete') {
            // Elimina un evento
            $idDaEliminare = $_POST['id_evento'];
            if ($eventController->eliminaEvento($idDaEliminare)) {
                echo "Evento eliminato con successo.<br>";
            }
        }
    }

    // Recupera tutti gli eventi e visualizzali
    $eventi = $eventController->getEventi();
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/styles/dashboard.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,700&display=swap" rel="stylesheet">
    
    <title>Admin Dashboard</title>
</head>
<body>

    <header>
        <svg class="edusogno" xmlns="http://www.w3.org/2000/svg" width="124" height="53" viewBox="0 0 124 53" fill="none">
            <path d="M63.8578 17.1194V19.0764H50.9451C51.4423 18.6273 51.691 17.9536 51.691 16.6703V3.30044C51.691 2.02521 51.4423 1.35151 50.9451 0.894348H63.5851V2.87537C63.1359 2.40217 62.5585 2.1776 61.2592 2.1776H57.0405V8.4976H59.9599C60.7666 8.5749 61.5743 8.36158 62.2377 7.89608V10.3503C61.5743 9.8848 60.7666 9.67148 59.9599 9.74878H57.0405V17.8172H61.5158C62.7831 17.8172 63.3846 17.5926 63.8337 17.1194H63.8578Z" fill="#2D224C"/>
            <path d="M74.2841 19.0764L74.0836 16.927C73.6559 17.6722 73.0299 18.2841 72.2752 18.6948C71.5205 19.1054 70.6667 19.2986 69.8087 19.2529C67.1059 19.2529 64.9324 17.1756 64.9324 12.6522C64.9324 8.1287 67.4828 6.0354 70.0092 6.0354C70.8334 6.02315 71.6458 6.23163 72.3622 6.63919C73.0786 7.04676 73.673 7.63858 74.0836 8.35326V3.17214C74.1617 2.37543 73.9479 1.57745 73.482 0.926461C74.6771 0.854278 77.6045 0.653768 79.377 0.429199V16.8227C79.3126 17.6255 79.5374 18.4248 80.0106 19.0764H74.2841ZM74.0836 15.3791V9.92525C73.9664 9.56711 73.7387 9.25536 73.4332 9.03485C73.1277 8.81434 72.76 8.69645 72.3832 8.69814C71.2043 8.69814 70.6108 9.54829 70.5867 12.7083C70.5626 15.8683 71.2043 16.7185 72.3832 16.7185C72.7723 16.714 73.1492 16.5821 73.4563 16.3432C73.7634 16.1042 73.9837 15.7712 74.0836 15.3951V15.3791Z" fill="#2D224C"/>
            <path d="M90.1004 19.0764L89.972 16.927C89.5895 17.6716 88.998 18.2883 88.2699 18.7015C87.5419 19.1147 86.709 19.3063 85.8736 19.2529C83.0505 19.2529 81.8635 17.6488 81.8635 14.6572V8.52168C81.9103 8.19606 81.8802 7.86401 81.7758 7.55207C81.6713 7.24013 81.4954 6.95694 81.262 6.72513C83.0826 6.64493 85.208 6.42036 87.1569 6.22787V14.8176C87.1569 15.8202 87.4055 16.6463 88.4321 16.6463C88.7092 16.6374 88.9776 16.5476 89.2042 16.388C89.4308 16.2283 89.6057 16.0059 89.7074 15.748V8.5297C89.7541 8.20408 89.7241 7.87204 89.6196 7.56009C89.5152 7.24815 89.3392 6.96496 89.1058 6.73315C90.9345 6.65295 93.0598 6.42838 95.0088 6.23589V16.8227C94.9332 17.6256 95.1434 18.4293 95.6023 19.0925L90.1004 19.0764Z" fill="#2D224C"/>
            <path d="M61.5638 22.9983L60.9863 24.4981C60.0692 23.7819 58.9418 23.3873 57.7782 23.3753C56.3025 23.3753 55.6288 23.7522 55.6288 24.6264C55.6288 26.2947 62.2054 26.9684 62.2054 30.9224C62.2054 33.922 59.5748 35.2935 55.3801 35.2935C53.6847 35.3896 51.994 35.0354 50.4797 34.2669L51.0331 32.7911C52.0901 33.5475 53.3586 33.9516 54.6583 33.9461C56.2624 33.9461 56.9762 33.4969 56.9762 32.5425C56.9762 30.3209 50.5599 30.6738 50.4797 26.3749C50.4797 23.9688 52.3565 22.0519 57.1767 22.0519C58.6936 22.0133 60.1978 22.3377 61.5638 22.9983Z" fill="#2D224C"/>
            <path d="M77.6045 28.7008C77.6045 32.2779 74.9338 35.3256 70.3863 35.3256C65.5741 35.3256 63.168 32.5024 63.168 28.7008C63.168 25.1318 65.8708 22.084 70.3863 22.084C75.1343 22.052 77.6045 24.8751 77.6045 28.7008ZM68.7822 28.7008C68.7822 33.3285 69.2073 34.315 70.3863 34.315C71.5652 34.315 71.9903 33.3446 71.9903 28.7008C71.9903 24.057 71.5893 23.1347 70.3863 23.1347C69.1832 23.1347 68.7822 24.049 68.7822 28.7008Z" fill="#2D224C"/>
            <path d="M100.92 35.1171H107.44C106.975 34.4568 106.761 33.6515 106.839 32.8473V27.2331C106.839 24.2094 105.82 22.0359 102.468 22.0359C101.683 22.0035 100.905 22.1867 100.218 22.5657C99.5309 22.9447 98.9607 23.5049 98.5697 24.1854V22.2204C97.118 22.4049 95.0728 22.7497 93.6773 22.9583C91.846 23.2018 89.9965 23.2796 88.1513 23.1909C87.0749 22.5233 85.8124 22.2196 84.5502 22.3247C81.1816 22.3247 78.936 24.3458 78.936 26.8241C78.9392 27.5649 79.1401 28.2915 79.518 28.9288C79.8958 29.5661 80.4369 30.0909 81.0854 30.4492C80.5393 30.7652 80.0914 31.2262 79.7913 31.7811C79.4912 32.3361 79.3506 32.9633 79.3851 33.5932C79.374 34.0081 79.4456 34.421 79.5957 34.8079C79.7458 35.1948 79.9714 35.548 80.2593 35.8469C79.8583 35.9849 79.5094 36.2428 79.2598 36.5856C79.0102 36.9285 78.8719 37.3398 78.8638 37.7638C78.8638 39.3678 81.6067 40.1699 84.7828 40.1699C88.5603 40.1699 91.4797 38.7182 91.4797 36.1597C91.4797 33.906 89.603 32.5345 84.8068 32.4623L82.4007 32.4142C81.6548 32.4142 81.4223 32.0854 81.4223 31.7325C81.4421 31.554 81.5111 31.3845 81.6215 31.2429C81.732 31.1013 81.8796 30.9932 82.0478 30.9305C82.8716 31.1968 83.7326 31.3294 84.5983 31.3234C88.023 31.3234 90.2687 29.3023 90.2687 26.8561C90.306 25.7871 89.9198 24.7466 89.1939 23.9608L93.4928 24.1693C93.5485 24.433 93.5754 24.7019 93.573 24.9714V32.8714C93.6505 33.6756 93.4371 34.4809 92.9715 35.1411H99.468C99.0024 34.4809 98.7889 33.6756 98.8664 32.8714V25.3483C99.0219 25.1195 99.2373 24.9378 99.4891 24.8233C99.7409 24.7087 100.019 24.6656 100.294 24.6987C101.321 24.6987 101.569 25.5007 101.569 26.4952V32.8473C101.633 33.6574 101.402 34.4633 100.92 35.1171ZM81.4784 36.3923L86.2906 36.6169C87.8946 36.689 88.5122 36.9938 88.5122 37.5713C88.5122 38.1487 87.6701 39.1753 84.7667 39.1753C83.3471 39.1753 81.318 38.6219 81.318 37.4029C81.2984 37.0584 81.3531 36.7137 81.4784 36.3923ZM84.5502 30.3931C83.6519 30.3931 83.299 29.7435 83.3311 26.8241C83.3632 23.9047 83.6519 23.2229 84.5502 23.2229C85.4485 23.2229 85.8013 23.8485 85.8013 26.8241C85.8013 29.7996 85.5046 30.3931 84.5502 30.3931Z" fill="#2D224C"/>
            <path d="M123.136 28.7008C123.136 32.2779 120.457 35.3256 115.918 35.3256C111.106 35.3256 108.699 32.5024 108.699 28.7008C108.699 25.1318 111.394 22.084 115.918 22.084C120.658 22.052 123.136 24.8751 123.136 28.7008ZM114.314 28.7008C114.314 33.3285 114.739 34.315 115.918 34.315C117.097 34.315 117.522 33.3446 117.522 28.7008C117.522 24.057 117.121 23.1347 115.918 23.1347C114.715 23.1347 114.338 24.049 114.314 28.7008Z" fill="#2D224C"/>
            <path d="M0 0.9104H45.0581V1.56005C45.0581 8.68209 45.1303 15.7961 45.0581 22.9101C44.9058 34.9406 39.5081 43.763 28.9614 49.5296C27.1006 50.5401 25.2159 51.4945 23.3471 52.4891C23.1033 52.6298 22.8267 52.704 22.5451 52.704C22.2635 52.704 21.9869 52.6298 21.7431 52.4891C19.6017 51.3502 17.4281 50.2754 15.3268 49.0884C11.443 47.0159 8.08655 44.0799 5.51561 40.5065C2.94468 36.933 1.22785 32.8174 0.49726 28.4762C0.191221 26.7447 0.0409062 24.9893 0.0481215 23.2309C-4.27255e-07 16.0127 0.0481215 8.79437 0.0481215 1.57609L0 0.9104ZM2.34995 3.23629V3.76564C2.34995 10.2541 2.34995 16.7425 2.34995 23.2309C2.35348 24.6135 2.45802 25.994 2.66274 27.3614C3.18763 31.1777 4.54803 34.8311 6.64694 38.0613C8.74585 41.2915 11.5316 44.0188 14.8055 46.0487C17.2116 47.5806 19.7701 48.7756 22.2724 50.107C22.365 50.1465 22.4645 50.1669 22.5652 50.1669C22.6658 50.1669 22.7654 50.1465 22.8579 50.107C24.0128 49.5215 25.1357 48.8879 26.2986 48.3105C29.75 46.7211 32.871 44.4953 35.4979 41.7498C40.064 36.9185 42.629 30.536 42.6761 23.8886C42.7723 17.1836 42.6761 10.4786 42.6761 3.77365C42.6761 3.60523 42.6761 3.42878 42.6761 3.23629H2.34995Z" fill="#2D224C"/>
            <path d="M25.5688 15.5234H18.4387V33.4488H25.5688V15.5234Z" fill="#2D224C"/>
            <path d="M18.3242 22.1327L13.4602 20.395L9.38032 31.8148L14.2443 33.5525L18.3242 22.1327Z" fill="#2D224C"/>
            <path d="M27.8165 11.5998L24.6555 12.764L32.2426 33.3628L35.4035 32.1986L27.8165 11.5998Z" fill="#2D224C"/>
          </svg>
    </header>

    <div class="bg-zone">
    <h1 class="title">Admin Dashboard</h1>
        <div class="main-content">
            <div class="index-ev">
                <h2 class="title">Elenco degli eventi</h2>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Nome Evento</th>
                        <th>Partecipanti</th>
                        <th>Data Evento</th>
                        <th>Azioni</th>
                    </tr>
                    <?php foreach ($eventi as $e): ?>
                        <tr>
                            <td><?php echo $e->getId(); ?></td>
                            <td><?php echo $e->getNomeEvento(); ?></td>
                            <td><?php echo $e->getAttendees(); ?></td>
                            <td><?php echo $e->getDataEvento(); ?></td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="id_evento" value="<?php echo $e->getId(); ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <input class="button" type="submit" value="Elimina">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <div>
                <h2 class="title">Aggiungi un nuovo evento</h2>
                <form class="form-add" method="post">
                    <input type="hidden" name="action" value="add">
                    <label for="nome_evento">Nome Evento:</label>
                    <input type="text" name="nome_evento" required><br>
                    <label for="attendees">Partecipanti:</label>
                    <input type="text" name="attendees" required><br>
                    <label for="data_evento">Data Evento:</label>
                    <input type="text" name="data_evento" required><br>
                    <input class="button" type="submit" value="Aggiungi Evento">
                </form>
            </div>
            <div>
                <h2 class="title">Modifica un evento</h2>
                <form class="form-mod" method="post">
                    <input type="hidden" name="action" value="edit">

                    <label for="id_evento">ID dell'evento da modificare:</label>
                    <input type="text" name="id_evento" required><br>

                    <label for="nome_evento">Nome Evento:</label>
                    <input type="text" name="nome_evento" required><br>

                    <label for="attendees">Partecipanti:</label>
                    <input type="text" name="attendees" required><br>

                    <label for="data_evento">Data Evento:</label>
                    <input type="text" name="data_evento" required><br>

                    <input class="button" type="submit" value="Modifica Evento">
                </form>
            </div>
        </div>
    </div>

    <?php
    // Chiudi la connessione al database
    $mysqli->close();
    ?>

</body>
</html>

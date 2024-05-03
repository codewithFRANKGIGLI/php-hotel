<?php
/* 
Partiamo da questo array di hotel. https://www.codepile.net/pile/OEWY7Q1G

Stampare tutti i nostri hotel con tutti i dati disponibili.
Iniziate in modo graduale. Prima stampate in pagina i dati, senza preoccuparvi dello stile. Dopo aggiungete Bootstrap e mostrate le informazioni con una tabella.

Bonus:
- Aggiungere un form ad inizio pagina che tramite una richiesta GET permetta di filtrare gli hotel che hanno un parcheggio.
- Aggiungere un secondo campo al form che permetta di filtrare gli hotel per voto (es. inserisco 3 ed ottengo tutti gli hotel che hanno un voto di tre stelle o superiore)

NOTA:
deve essere possibile utilizzare entrambi i filtri contemporaneamente (es. ottenere una lista con hotel che dispongono di parcheggio e che hanno un voto di tre stelle o superiore) Se non viene specificato nessun filtro, visualizzare come in precedenza tutti gli hotel.
*/


$hotels = [

    [
        'name' => 'Hotel Belvedere',
        'description' => 'Hotel Belvedere Descrizione',
        'parking' => true,
        'vote' => 4,
        'distance_to_center' => 10.4
    ],
    [
        'name' => 'Hotel Futuro',
        'description' => 'Hotel Futuro Descrizione',
        'parking' => true,
        'vote' => 2,
        'distance_to_center' => 2
    ],
    [
        'name' => 'Hotel Rivamare',
        'description' => 'Hotel Rivamare Descrizione',
        'parking' => false,
        'vote' => 1,
        'distance_to_center' => 1
    ],
    [
        'name' => 'Hotel Bellavista',
        'description' => 'Hotel Bellavista Descrizione',
        'parking' => false,
        'vote' => 5,
        'distance_to_center' => 5.5
    ],
    [
        'name' => 'Hotel Milano',
        'description' => 'Hotel Milano Descrizione',
        'parking' => true,
        'vote' => 2,
        'distance_to_center' => 50
    ],

];


// Intanto mi prendo la lista intera degli hotels
// se c'è il filtro del park mi segno in un altro 'foglio' solo gli hotels
// col parcheggio e poi stampo

$parking_filter = isset($_GET['parking']) && $_GET['parking'] === '1' ? true : false;
$vote_filter = isset($_GET['vote']) ? intval($_GET['vote']) : 0;

$filteredHotels = $hotels;
if($parking_filter) {
    $hotelsWithParking =[];
    foreach($filteredHotels as $hotel) {
        if($hotel['parking']) {
            $hotelsWithParking[] = $hotel;
        }
    }
    $filteredHotels = $hotelsWithParking;
};

// se c'è il filtro del voto ci creiamo un array di appoggio dove salviamo gli hotels con un voto uguale o maggiore al filtro
if($vote_filter > 0) {
    $hotelsFilteredByVote = [];

    foreach($filteredHotels as $hotel) {
        if($hotel['vote'] >= $vote_filter ) {
            $hotelsFilteredByVote[] = $hotel;
        }
    }
    $filteredHotels = $hotelsFilteredByVote;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

    <div class="d-flex align-items-center pt-2">
        <ul>
            <?php foreach ($hotels as $key => $value) : ?>
                <li>
                    <?= $value['name']; ?>
                    <ul>
                        <li>
                            <?= $value['description']; ?>
                        </li>
                        <li>
                            <?= 'voto ' . $value['vote'] . ' su 5' ?>
                        </li>
                        <li>
                            <?= $value['distance_to_center'] . ' km'; ?>
                        </li>
                    </ul>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="container">

            <form action="" method="GET">

                <div class="d-flex align-items-center gap-3 ">
                    
                    <label for="parking">Parcheggio</label>
                    <input class="form-check-input" type="checkbox" <?php echo $parking_filter ? 'checked' : ''; ?> name="parking" id="parking" value="1">
                    <button class="btn btn-primary" type="submit">Enter</button>
                </div>

                <div class="d-flex align-items-center gap-3 py-2">
                    <label class="form-label" for="vote">Voto:</label>
                    <select name="vote" id="vote" class="form-select">
                        <option <?php echo $vote_filter === 0 ? 'selected' : '' ?> value="0">Tutti</option>
                        <option <?php echo $vote_filter === 1 ? 'selected' : '' ?> value="1">1</option>
                        <option <?php echo $vote_filter === 2 ? 'selected' : '' ?> value="2">2</option>
                        <option <?php echo $vote_filter === 3 ? 'selected' : '' ?> value="3">3</option>
                        <option <?php echo $vote_filter === 4 ? 'selected' : '' ?> value="4">4</option>
                        <option <?php echo $vote_filter === 5 ? 'selected' : '' ?> value="5">5</option>
                    </select>

                </div>

            </form>


            <table class="table table-striped py-2">
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Descrizione</th>
                        <th scope="col">Parcheggio</th>
                        <th scope="col">Voto</th>
                        <th scope="col">Distanza dal centro</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    #var_dump($_POST);
                    if ($_POST) {
                        # code...
                    }
                    foreach ($filteredHotels as $key => $value) : ?>
                        <tr>
                            <td>
                                <?= $value['name']; ?>
                            </td>

                            <td>
                                <?= $value['description']; ?>
                            </td>

                            <td>
                                <?= $value['parking'] ? 'Si' : 'No'; ?>
                            </td>
                            
                            <td>
                                <?= $value['vote']; ?>
                            </td>

                            <td>
                                <?= $value['distance_to_center'] . ' km'; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
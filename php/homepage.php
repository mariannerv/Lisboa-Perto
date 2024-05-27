<!DOCTYPE html>
<html lang="en">
<head>
    <title>SOBRE</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/homepage.css"> <!-- Link to your external CSS file -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        #map { height: 600px; width: 100%; border: 5px solid white; }
        .map-container {
            width: 90%;
            margin: 0 auto;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <?php include "navbar.php"; 
    session_start();
    ?>

    <div class="bgimg w3-display-container w3-text-white">
        <img src="Imagens/lisboa.jpeg" alt="Lisboa" style="width: 100%; height: auto;">
        <div class="w3-display-middle fade-in-text">
            <h1>LISBOA</h1>
            <h2>+ PERTO</h2>
            <div class="map-container">
                <div id="map"></div>
            </div>
        </div>
    </div>

    <script>
        var map = L.map('map').setView([38.736946, -9.142685], 12); // Centro de Lisboa

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        $.get('select.php', function(data) {
            var datpars = JSON.parse(data);
            datpars.ocorrencia.forEach(function(occ) {
                var marker = L.marker([occ.Latitude, occ.Longitude]).addTo(map);
                marker.bindPopup(
                    '<b>Descrição:</b> ' + occ.descricao + '<br>' +
                    '<b>Subcategoria:</b> ' + occ.subCategoria + '<br>' +
                    '<b>Categoria:</b> ' + occ.categoria + '<br>' +
                    '<b>ID Utilizador:</b> ' + occ.ID_utilizador
                );
            });
        });
    </script>

</body>
</html>

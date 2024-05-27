<?php
session_start();

if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: login.php");
    exit();
}
?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/formulario_ocorrencia.css" />
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" type="text/css" href="../css/formulario_ocorrencia.css" />
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        #mapid { height: 400px; }
    </style>
</head>
<body>
<?php include "navbar.php"; ?>

<div class="container">
  <h3>Regista uma nova ocorrência</h3>

  <div class="form_ocorrencias">
      <form action="insere_ocorrencia.php" method='POST' id="ocorrenciaForm" enctype="multipart/form-data">
          <label for="categoria">Categoria</label>
          <select id="categoria" name="categoria" required>
              <option value="">Select Categoria</option>
              <option value="Passeios e Acessibilidades">Passeios e Acessibilidades</option>
              <option value="Higiene Urbana">Higiene Urbana</option>
              <option value="Iluminação Pública">Iluminação Pública</option>
              <option value="Estradas e Ciclovias">Estradas e Ciclovias</option>
              <option value="Árvores e espaços verdes">Árvores e espaços verdes</option>
              <option value="Equipamentos Municipais - Desporto">Equipamentos Municipais - Desporto</option>
              <option value="Segurança pública e ruído">Segurança pública e ruído</option>
              <option value="Saneamento">Saneamento</option>
              <option value="Habitação municipal">Habitação municipal</option>
              <option value="Animais em ambiente urbano">Animais em ambiente urbano</option>
              <option value="Equipamentos Municipais - cultura">Equipamentos Municipais - cultura</option>
              <option value="Equipamentos municipais - educação">Equipamentos municipais - educação</option>
          </select>

          <label for="subCategoria">Sub-Categoria</label>
          <select id="subCategoria" name="subCategoria" required>
              <option value="">Seleciona uma Subcategoria</option>
          </select>
          <br><br>
          <label for="foto">Foto</label>
          <input type="file" name="foto"><br><br>

          <label for="localizacao">Localização (Rua, localidade, morada...)</label>
          <input type="text" id="localizacao" name="localizacao" placeholder="localizacao.." required>

          <label for="titulo">Titulo da ocorrência</label>
          <input type="text" id="titulo" name="titulo" placeholder="titulo.." required>

          <label for="descricao">Descrição da ocorrência</label>
          <input type="text" id="descricao" name="descricao" placeholder="descricao.." required>

          <label for="latitude">Latitude</label>
          <input type="text" id="Latitude" name="Latitude" readonly><br>

          <label for="longitude">Longitude</label>
          <input type="text" id="Longitude" name="Longitude" readonly><br>

          <div id="mapid" style="width: 100%; height: 400px;"></div>

          <input type="submit" value="Submit">
      </form>
  </div>
</div>

<script src="../scripts/subcategoria.js"></script> 

<script>
    var map = L.map('mapid').setView([38.736946, -9.142685], 12); // Centro de Lisboa

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var marker;

    function onMapClick(e) {
        if (marker) {
            map.removeLayer(marker);
        }
        marker = L.marker(e.latlng).addTo(map);

        document.getElementById('Latitude').value = e.latlng.lat;
        document.getElementById('Longitude').value = e.latlng.lng;
    }

    map.on('click', onMapClick);
</script>

<?php
if ($form_submitted) {
    echo '<script>alert("Ocorrência submetida com sucesso!");</script>';
}
?>

</body>
</html>
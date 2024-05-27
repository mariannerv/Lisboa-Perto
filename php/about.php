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
    <style>
        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: "Lato", sans-serif
        }

        .w3-bar,
        h1,
        button {
            font-family: "Montserrat", sans-serif
        }

        .fa-anchor,
        .fa-coffee {
            font-size: 200px
        }
    </style>
</head>

<body>

    <!-- Include the navigation bar -->
    <?php include_once "navbar.php"; ?>

    <!-- Header -->
    <header class="w3-container w3-indigo w3-center" style="padding:128px 16px">
        <h1 class="w3-margin w3-jumbo">SOBRE O PROJETO</h1>
        <img src="Imagens/logo.png" height="350px" width="450px">
    </header>

    <!-- First Grid -->
    <div class="w3-row-padding w3-padding-64 w3-container">
        <div class="w3-content">
            <div class="w3-twothird">
                <h1>Objetivo</h1>
                <h5 class="w3-padding-32">Permitir que os cidadãos relatem ocorrências ou problemas
                detetados no espaço público, equipamentos municipais e higiene urbana que necessitem da
                intervenção da CML ou das Juntas de Freguesia, como buracos nas estradas, lâmpadas de rua
                queimadas, lixo acumulado, entre outras.</h5>

                <p class="w3-text-grey">Será também possível aos cidadãos pesquisarem problemas por zona e categoria, subcategoria e estado.
                    Para além disso, será também possível entrar em contacto diretamente com funcionários da CML e dar feedback no final da resolução
                    de uma ocorrência. 
                </p>
            </div>

            <div class="w3-third w3-center">
                <i class="fa fa-anchor w3-padding-64 w3-text-indigo"></i>
            </div>
        </div>
    </div>

    <!-- Second Grid -->
    <div class="w3-row-padding w3-light-grey w3-padding-64 w3-container">
        <div class="w3-content">
            <div class="w3-third w3-center">
                <i class="fa fa-coffee w3-padding-64 w3-text-indigo w3-margin-right"></i>
            </div>

            <div class="w3-twothird">
                <h1>EQUIPA</h1>
                <h5 class="w3-padding-32">Grupo 24</h5>

                <p class="w3-text-grey">Grupo composto por 3 estudantes de LTI altamente motivados para trazer esta aplicação à vida
                    de forma a melhorar a resposta e rapidez dos funcionários da CML aos problemas reportados pelos cidadãos.
                </p>
            </div>
        </div>
    </div>


    <!-- Footer -->
    <footer class="w3-container w3-padding-64 w3-center w3-opacity">
        <div class="w3-xlarge w3-padding-32">
            <i class="fa fa-facebook-official w3-hover-opacity"></i>
            <i class="fa fa-instagram w3-hover-opacity"></i>
            <i class="fa fa-snapchat w3-hover-opacity"></i>
            <i class="fa fa-pinterest-p w3-hover-opacity"></i>
            <i class="fa fa-twitter w3-hover-opacity"></i>
            <i class="fa fa-linkedin w3-hover-opacity"></i
        </div>
        <p>GRUPO 24</p>
    </footer>

    <script>
        // Used to toggle the menu on small screens when clicking on the menu button
        function myFunction() {
            var x = document.getElementById("navDemo");
            if (x.className.indexOf("w3-show") == -1) {
                x.className += " w3-show";
            } else {
                x.className = x.className.replace(" w3-show", "");
            }
        }
    </script>

</body>

</html>

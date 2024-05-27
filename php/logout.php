<!DOCTYPE html>
<html>
<head>
    <title>W3.CSS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>

<?php include "navbar.php"; ?>

<div class="w3-container w3-half w3-margin-top w3-display-middle">
    <form class="w3-container w3-card-4" method="post">
        <h1 class="w3-container w3-teal" style="width:90%">Bem vindo!</h1>
        <?php
session_start();
session_destroy();
echo 'You have been logged out. <a href="/">Go back</a>';
header("Location: homepage.php");
?>

</div>

</body>
</html>

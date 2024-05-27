

    <html>

    <body>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <h3>Form</h3>
    <style>
input[type=text], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=submit] {
  width: 100%;
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}

div {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}
</style>fff
    <div>
    <form action="insere.php" method='POST'>
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" placeholder="Nome..">

        <label for="idade">Idade</label>
        <input type="text" id="idade" name="idade" placeholder="Idade..">

        <label for="email">Email</label>
        <input type="text" id="email" name="email" placeholder="Email..">


        <label for="passwd">password</label>
        <input type="password" minlength="8" id="passwd" name="passwd" placeholder="Password..">
    
        <input type="submit" value="Submit">
    </form>
    </div>

    </body>
    </html>


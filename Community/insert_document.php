<html>
<head>
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z"
          crossorigin="anonymous"/>
    <title>Upload Documenti</title>
</head>
<body>
<form action="upload_document.php" method="post" enctype="multipart/form-data">
    <!--Titolo&nbsp;<input type="text" name="titolo"><br>
    Tipo&nbsp;<input type="text" name="tipo_doc"><br>-->
    Descrizione&nbsp;<input type="text" name="descrizione"><br>
    <!--Data&nbsp;<input type="date" name="data"><br>-->
    <?php
    session_start();
    $_SESSION["data_upload"] = date("Y-m-d");
    /*
    $keyu = $_SESSION['keyu'];
    $tipo = $_SESSION['tipo'];
    $email = $_SESSION['email'];
    $password = $_SESSION['password'];
    $keyu = $_POST['keyu'];
    $tipo = $_POST['tipo'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    echo("<input type='text' hidden name='tipo' value='$tipo'>");
    echo("<input type='text' hidden name='keyu' value='$keyu'>");
    echo("<input type='text' hidden value='$email' name='email'>");
    echo("<input type='text' hidden value='$password' name='password'>");*/
    ?>
    Inserisci Documento&nbsp;<input type="file" name="documento">
    <input type="submit" value="Upload">
</form>
<form action="index.html">
    <input type="submit" value="Home">
</form>
</body>
</html>
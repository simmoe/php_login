<h1>Velkommen, <?php echo $_SESSION['fornavn']." ".$_SESSION['efternavn'];?></h1>
<p>Du er nu logget på. Du har rollerne: <?php echo $_SESSION['roller']?></p>
<a href = "logout.php">Log ud</a>
<hr/>
<h2>Din profil</h2>

<?php

if($_SERVER["REQUEST_METHOD"] == "POST") {
      // values sent from form       
    $escapedFornavn = mysqli_real_escape_string($conn, $_POST['fornavn']); 
    $escapedEfternavn = mysqli_real_escape_string($conn, $_POST['efternavn']); 
    $escapedAlder = mysqli_real_escape_string($conn, $_POST['alder']); 
    $escapedEmail = mysqli_real_escape_string($conn, $_POST['email']); 
    $escapedAdresse = mysqli_real_escape_string($conn, $_POST['adresse']); 
    $escapedTelefon = mysqli_real_escape_string($conn, $_POST['telefon']); 
    $escapedKoen = mysqli_real_escape_string($conn, $_POST['koen']); 
    
    if($escapedFornavn == "" || $escapedEfternavn == "" || $escapedEmail == "" || $escapedAdresse == "" || $escapedTelefon == "" || $escapedKoen == ""){
        $msg = "Udfyld venligst alle felterne";
    }else{          
        # Opdater profil 
        $query = "UPDATE Person SET fornavn = '$escapedFornavn', 
                efternavn = '$escapedEfternavn', 
                alder = '$escapedAlder', 
                email = '$escapedEmail', 
                adresse = '$escapedAdresse', 
                telefon = '$escapedTelefon', 
                køn = '$escapedKoen'
                WHERE id = ".$_SESSION['id'];
        if ($result = $conn->query($query)) {
                # så registrerer vi i den nuværende session, at brugeren er blevet opdateret
                $_SESSION['fornavn'] = $escapedFornavn;
                $_SESSION['efternavn'] = $escapedEfternavn;
                $_SESSION['alder'] = $escapedAlder;
                $_SESSION['email'] = $escapedEmail;
                $_SESSION['adresse'] = $escapedAdresse;
                $_SESSION['koen'] = $escapedKoen;
                $_SESSION['telefon'] = $escapedTelefon;
           echo "<h4>Profil opdateret</h4>";            
	    # Eller hvis noget går galt, giv en fejl
        } else {
    	   $msg = "Fejl: " . $query . "<br>" . $conn->error;
	    }         
   }
}

?>
    <form action="?welcome=true&update=true" method="post">
        <label>Fornavn:</label><input type="text" name="fornavn" required value = '<?php echo $_SESSION['fornavn'];?>'/><br/><br />
        <label>Efternavn:</label><input type="text" name="efternavn" required value = '<?php echo $_SESSION['efternavn'];?>'/><br/><br />
        <label>Alder:</label><input type="number" name="alder" required value = '<?php echo $_SESSION['alder'];?>'/><br/><br />
        <label>Email:</label><input type="email" name="email" required value = '<?php echo $_SESSION['email'];?>'/><br/><br />
        <label>Adresse:</label><textarea name="adresse" required><?php echo $_SESSION['adresse'];?></textarea><br/><br />
        <label>Telefon:</label><input type="number" name="telefon" value = '<?php echo $_SESSION['telefon'];?>'/><br /><br />
        <label>Køn:</label><input type="text" name="koen" placeholder="M/K" maxlength="1" size="2" value = '<?php echo $_SESSION['koen'];?>' /><br /><br />
        <input type="submit" value=" Submit " /><br />
    </form>


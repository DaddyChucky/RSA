<!DOCTYPE html>

<html>
    
    <link rel="stylesheet" href="background.css" />
    
    <?php
        include 'session.php';
        include 'vars.php';
        include 'functions.php';
        
        //CHECK IF ACCOUNT IS ALREADY REGISTERED
        //NUMBER OF ENTRIES EQUALS USED ENTRIES
        $entryNum = 0;
        $usedNum = 0;

        $req = $database->prepare('SELECT ID FROM list');

        $req->execute();

        while ($result = $req->fetch())
        {
        	if ($result)
        	{
        		$entryNum++;
        	}
        }

        $req = $database->prepare('SELECT ID FROM list WHERE used=:used');

        $req->execute(array(
        	'used' => 1
        ));

        while ($result = $req->fetch())
        {
        	if ($result)
        	{
        		$usedNum++;
        	}
        }
    
        if ($entryNum != 0 || $usedNum != 0)
        {
            if ($entryNum == $usedNum)
            {
            	if (!isset($_SESSION['logged']) || $_SESSION['logged'] == false)
            	{
            		$_SESSION['logged'] = true;
            	}
            	
            	else
            	{
            	    $_SESSION['logged'] = false;
            	}
            	
            	header('Location: ../account');
            }
        }
        

        //QUICK LOG IN IF ALREADY REGISTERED
        if (isset($_SESSION['logged']) && $_SESSION['logged'] == true)
        {
        	header('Location: ../account');
        }

        else
        {
        	//REGARDONS SI ON DOIT AFFICHER L'ENCRYPTION OU LA DECRYPTION.
			$req = $database->prepare('SELECT registered FROM account');
			$req->execute();
			
			while ($result = $req->fetch())
			{
				if ($result)
				{
					$_SESSION['registered'] = $result['registered'];
					break;
				}
			}	
			
	        if ($_SERVER['REQUEST_METHOD'] === "POST")
	        {
	            if (isset($_POST['key']) && isset($_POST['create']))
	            {
					//SI LA CLEF FOURNIE EST INCOMPATIBLE
					if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%?&*()-_=+;.<>,|\']{2,100}$/', $_POST['key']))
					{
						$_SESSION['curErr'] = 'La clef fournie est invalide. Votre mot de passe doit être entre deux (2) et cent (100) caractères et doit obligatoirement contenir au moins un (1) chiffre et une (1) lettre dans la chaîne de caractères prescrite. Ni les accents, ni les espaces, ni les symboles non fréquemment utilisés ne sont acceptés.';
					}

					//SINON, COMMENCONS L'ENCRYPTION DE CHAQUE LETTRE DE LA CLEF SECRETE. CHAQUE LETTRE POSSEDE UNE ENCRYPTION UNIQUE.

					else
					{
						$i = 0; //VARIABLE UTILISEE COMME INCREMENTATION
	                
		                while ($i < strlen($_POST['key']))
		                {
		                    $letterInNumber = substr($_POST['key'], $i, 1);
		                    start($letterInNumber);
		                    $i++;
		                }
		                
						//METTONS A JOUR LA BASE DE DONNEE COMME QUOI LE COMPTE EST DEJA CREE, MONTRER QUE LA PAGE DE CONNEXION.
						$req = $database->prepare('UPDATE account SET registered=:registered');
						
						$req->execute(array(
							'registered' => 1
						));
										
		                header('Location: index');

		                /*DEBUG:
		                $_SESSION['curInf'] = 'Chaque caractère a été encrypté selon les paramètres suivants: ' . $_SESSION['cryptInfo'];
		                $_SESSION['cryptInfo'] = '';*/
					}  
	            }
				
				if (isset($_POST['secret']) && isset($_POST['enter']))
				{
					$secretSize = strlen($_POST['secret']);
					//SI LA CLEF FOURNIE EST VIDE
					if (empty($_POST['secret']))
					{
						$_SESSION['curErr'] = 'La clef fournie est invalide.';
					}
					
					//SINON, COMMENCONS LA DECRYPTION DE CHAQUE LETTRE DE LA CLEF SECRETE.

					//LONGUEUR DU MOT DE PASSE EMIS
					$_SESSION['constPassLength'] = $secretSize;
					$_SESSION['passLength'] = $secretSize - 1;

					//REGARDONS SI LE MOT DE PASSE A LE NOMBRE DE CARACTERE REQUIS
					$database = new PDO('mysql:host=*****;dbname=*****;charset=utf8', '*****', '*****');

					$i = 0;

					$req = $database->prepare('SELECT ID FROM list');

					$req->execute();

					while ($result = $req->fetch())
					{
						if ($result)
						{
							$i++;
						}
					}

					if ($i != $secretSize)
					{
						$_SESSION['curErr'] = 'Clef invalide (ERR #1).';
					}

					else
					{
						$i = 0;
					
						while ($i < strlen($_POST['secret'])) //COMMENCONS LA DECRYPTION DE CHAQUE CARACTERE
						{
		                    $letterInNumber = substr($_POST['secret'], $i, 1);
		                    
		                    decrypt($letterInNumber);
		                    $i++;
		                    $_SESSION['passLength']--;
		                }

		                
		                if ($_SESSION['decryptedChars'] == $_SESSION['constPassLength'])
						{
							$_SESSION['logged'] = true;
							header('Location: account');
						}

						else
						{
							$database = new PDO('mysql:host=*****;dbname=*****;charset=utf8', '*****', '*****');

							$req = $database->prepare('UPDATE list SET used=:used');

							$req->execute(array(
								'used' => 0
							));
						}
					} 
				}

				if (isset($_POST['reset']))
	            {
	                $req = $database->prepare('UPDATE account SET registered=:registered');

	                $req->execute(array(
	                    'registered' => 0
	                ));

	                
	                $req = $database->prepare('DELETE FROM list');

	                $req->execute();

	                session_destroy();
	                
	                header('location: ../index');
	            }
	        }
        }
		
    ?>
    
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Charles De Lafontaine, Vincent Boogaart (c)">
        <meta name="viewporth" content="width=device-width, initial-scale=1.0">
        
        <!-- OVERALL USE OF ICONS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        
        <!-- PAGE NAV. ICON -->
        <link rel="icon" href="https://img.icons8.com/cotton/2x/lock.png">
        
        <!-- FONTS -->
        <link href="https://fonts.googleapis.com/css?family=Blinker:100,400,900&display=swap" rel="stylesheet" />
        
        <title>C&V | Solutions bancaires</title>
    </head>
    
    <body>
        
        <div id="content">
            <h1 style="font-size: 68px; font-family: 'Blinker';">C&V | Solutions bancaires</h1>
            
            <h2 style="font-size: 40px; text-indent: 60px; font-style: italic; text-align: center;">Votre protection, notre priorité.</h2>
            
            <?php include 'cur.php'; ?>
            
			<br/>
			
			<?php
				if ($_SESSION['registered'] == 0)
				{
			?>
			<p><i class="material-icons" style="padding-right: 8px; color:rgb(30,144,255);">create</i><span style="font-size: 38px; font-family: 'Blinker'; text-align: left;">Création de votre compte <b>client</b> :</span>

            <div id="form" style="margin-left: 2%; margin-right: 2%; margin-bottom: 10%; border: 5px groove rgb(30,144,255); padding: 25px; border-radius: 4%; background: rgba(255,255,255,0.1);">
                				
				<h4 style="font-size: 25px; font-family: 'Blinker'; text-align: left;">Pour débuter, veuillez créer ci-bas une clef unique<b>*</b> pour accéder à vos soldes lors des prochaines connexions.</h4>
				
				<span style="font-size: 16px; font-style: italic; text-align: justify;"><b>*</b>Votre clef doit obligatoirement contenir au moins deux (2) caractères (et au plus cent [100]), dont au moins un (1) chiffre et une (1) lettre de votre choix. Les espaces, les accents et certains symboles non couramment utilisés ne sont pas tolérés.</span>
				
                <form id="create" target="" method="post">
                    <input type="password" name="key" placeholder="Élaborez votre clef"><br/>
                    <input type="submit" name="create" value="Créer">
                </form>
            </div>
			
			<?php
				}
				
				else if ($_SESSION['registered'] == 1)
				{
					$_SESSION['curSuc'] = 'Compte créé. Veuillez vous identifier.';
			?>
			<?php include 'cur.php'; ?>

			<p><i class="material-icons" style="padding-right: 8px; color: indianred;">account_box</i><span style="font-size: 38px; font-family: 'Blinker'; text-align: left;">Connectez-vous à votre compte, cher <b>client</b> / chère <b>cliente</b> :</span>

            <div id="form" style="margin-left: 2%; margin-right: 2%; margin-bottom: 10%; border: 5px groove indianred; padding: 25px; border-radius: 4%; background: rgba(255,255,255,0.1);">
                				
				<h4 style="font-size: 25px; font-family: 'Blinker'; text-align: left;">Pour accéder à vos soldes, veuillez entrer ci-bas votre clef unique et secrète préalablement créée.</h4>
								
				<style>
					#reset
					{
						text-align: center;
					}

					#reset input[type=submit]
				    {
				        font-size: 14px;
				        width: 30%;
				        background-color: rgba(55,0,0,0.6);
				        color: white;
				        padding: 12px 18px;
				        margin: 8px 0;
				        border: none;
				        border-radius: 4px;
				        cursor: pointer;
				    }

				    #reset input[type=submit]:hover
				    {
				        background-color: rgba(205,92,92,0.6);
				        transition: 0.5s ease-in-out;
				    }
				</style>
                <form id="enter" target="" method="post">
                    <input type="password" name="secret" placeholder="Votre clef secrète"><br/>
                    <input type="submit" name="enter" value="Entrer"><br/>
                </form>

                <form id="reset" target="" method="post">
                    <input type="submit" style="" id="reset" name="reset" value="Rénitialiser le mot de passe">
                </form>
            </div>
            
			<?php
				}
				
				else
				{
					$_SESSION['curErr'] = 'Erreur interne d\'initiation de variables. Impossible d\'afficher les options clients.';
				}
			?>
    
        </div>
        
    </body>
    
</html>

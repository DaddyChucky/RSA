<?php
    include 'session.php';
    
	//FOR SQL INJECTION
	function test_input($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);

		return $data;
	}

	function factoriel($num)
    {
        $sum = $num;

        while ($num > 1)
        {
            $num--;

            $sum = $sum * $num;

        }

        return $sum;
    }

	function mod($x, $y)
	{
		return ($x % $y + $y) % $y;
	}

	function searchNumberOfLines()
	{
        $nb = 0;
        
	    $primes = fopen("primes-to-100k.txt", "r");
	    
	    while (!feof($primes))
        {
            if (fgets($primes))
            {
                $nb++;
            }
        }
        
	    fclose($primes);
	    
	    return $nb;
	}
	
	function init($letter, $p, $q)
	{
	    //INITIALISATION DES VARIABLES
	    $n = 0;
	    $A = 0;
	    $E = 0;
	    $D = 0;
	    $nb = 0;
	    $min = 2;
	    $max = 0;
	    
	    //CHAQUE CARACTERE DU MOT DE PASSE CHOISI A UN "n" QUI LUI EST ATTRIBUE. TOUS LES "n" MIS COTE-A-COTE FORMENT LA CLE PUBLIQUE.
	    $n = $p * $q;
	    
	    $A = ($p - 1)*($q - 1);
	    
	    //TROUVER "E" COMME QUOI 1 < E < A, ET "E" EST PREMIER A "A"
	    //LIMITONS LE MAXIMUM DE E POUR EVITER LE TEMPS DE CALCUL TROP IMPORTANT.
	    $lengthOfA = ceil(log10(abs($A) + 1));
	    
		$max = round(($A - 1) / (10 ** ($lengthOfA / 1.7)), 0); //NOUS AVONS GRANDEMENT REDUIT LES PIOCHES POSSIBLES DE E, EN CALCULANT LE NOMBRE DE CHIFFRES DANS A ET DIVISANT LE NOMBRE DE TOTAL DE POSSIBILITES DE PIOCHE PAR UNE FRACTION DE CE NOMBRE DE CHIFFRES.
	    
	    //echo $A . ' // ' . $lengthOfA . ' // ' . $max;
	    
	    //TROUVER LA LIGNE ALEATOIRE OU SE TROUVE "E"
	    $E = rand($min, $max);
	    
	    $primes = fopen("primes-to-100k.txt", "r");
	    
	    while (!feof($primes))
        {
            if (fgets($primes))
            {
                $nb++;
                if ($nb == $E)
                {
                    //NOUS AVONS "E"
                    $E = fgets($primes);
                }
            }
        }
        
        //"D" EST SUPPOSE ETRE UN ENTIER. CEPENDANT, POUR TROUVER "D", MEME AVEC L'ALGORITHME D'EUCLIDE ETENDU ET LE THEOREME DE BEZOUT, CELA PREND PLUSIEURS MINUTES, VOIRE HEURES OU MEME JOURS, A TROUVER L'ENTIER EN QUESTION, AVEC DE TRES GROS NOMBRES PREMIERS. NOUS ALLONS DONC PRENDRE "D" COMME ETANT UNE VALEUR A DECIMALES ET LA STOCKER DANS LA BASE DE DONNEES AVEC LE NOMBRE DE CHIFFRES APRES LA VIRGULE SOUHAITE (DOUBLE).

        
        $Aprime = $A; //ON CREE UNE VARIABLE Aprime QUI STOCKE D'ABORD LA VALEUR A
        $Eprime = $E; //ON CREE UNE VARIABLE Eprime QUI STOCKE D'ABORD LA VALEUR E   

        $reste = $Aprime % $Eprime; //LE RESTE DE LA DIVISION ENTRE Aprime et Eprime

        $quotient = floor($Aprime / $Eprime); //LE QUOTIENT DE Aprime DIVISE PAR Eprime   

        // NOUS AVONS MAINTENANT L'EQUATION SOUS FORME: RESTE = APRIME - QUOTIENT * EPRIME
        $i = 0;

        while ($reste > 0) //ON ARRETE A 1 ET NON A 0, CAR C'EST LA D'OU ON PART, C'EST CE QUI NOUS INTERESSE
        {

        	$PGCD[$i][1] = $Aprime; 
        	$Aprime = $Eprime;

        	$PGCD[$i][3] = $Eprime;
        	$Eprime = $reste;

            $PGCD[$i][0] = $reste; //ON STOCKE DANS UN TABLEAU 2D, LES VALEURS INITIALES DE BEZOUT
           	$reste = $Aprime % $Eprime;

            $PGCD[$i][2] = -$quotient; 
            $quotient = floor($Aprime / $Eprime); //PROBLEME RENCONTRE AVEC L'UTILISATION DU round (ANALYSE), ON VEUT TOUJOURS LA VALEUR DU DESSOUS

           $i++; //ON CREE UNE AUTRE LIGNE DANS LE TABLEAU PGCD ET ON STOCKE LES MEMES VALEURS JUSQU'A LA FIN DU THEOREME
        }
        
        //AVEC TOUTES LES DONNEES EN MAIN, NOUS PASSONS MAINTENANT AU THEOREME D'EUCLIDE ETENDU, AFIN DE TROUVER L'INVERSE E MODULO n

        $i = sizeof($PGCD) - 1; //NOUS COMMENCONS PAR LA FIN DU TABLEAU, SOIT PAR LES PETITES VALEURS POUR REMONTER VERS LES PLUS GROSSES VALEURS
        $z = 0; //NOMBRE DE FOIS OU LA BOUCLE S'EST REPETEE

        //SOUS FORME: $reste = $u * $a + $v * $b, OU u ET v SONT LES INVERSES MODULOS

        $u = 1;				//coefficient avant aprime

        $v = $PGCD[$i][2]; 	//quotient initial
        
        while ($i > -1) //A CHANGER POUR 0
        {
        	/*
        	echo $PGCD[$i][0] . ' = ' . $PGCD[$i][1] . ' ' . $PGCD[$i][2] . '*' . $PGCD[$i][3] . ' //U= ' . $u . ' //V= ' . $v;
        	?><br/><?php*/

        	if (($z % 2) == 0) //EN D'AUTRES TERMES, SI N EST PAIR (COMMENCEMENT DE LA BOUCLE)
        	{
        		$u = $u + $v * $PGCD[$i - 1][2]; //u correspond a son quotient multiplie au quotient de la ligne superieur du tableau, v est constant
        	}

        	else //SINON, FAIRE LE CALCUL POUR N IMPAIR
        	{
        		$v = $v + $u * $PGCD[$i - 1][2]; //u est constant

        	}

        	$z++;
        	$i--;
        }

        //ON CHOISIT LE PLUS GROS NOMBRE COMME ETANT NOTRE D
        
        if (abs($u) > abs($v))
        {
            //AVOIR VALEURS STRICTEMENT POSITIVES, ON ADDITIONNE AVEC A, CE QUI NE CHANGE PAS L'INVERSE MODULO (THEOREME)
            if ($u < 0)
            {
                $u = $u + $A; 
            }
            
        	$D = $u;
        }

        else
        {
            //AVOIR VALEURS STRICTEMENT POSITIVES, ON ADDITIONNE AVEC A, CE QUI NE CHANGE PAS L'INVERSE MODULO (THEOREME)
            if ($v < 0)
            {
                $v = $v + $A;
            }
            
        	$D = $v;
        }

        //$D = $v + $n; //STRICT. POSITIF BUG EN HAUT DE M=27 ????
        
        /*
        $u = -100000;
        $v = -100000;
        $reste = 1;
        
        while ($u < 100000)
        {
            $reste = $u * $n + $v * $E;
            
            if ($reste != 1)
            {
               while ($v < 100000)
                {
                   
                    $reste = $u * $n + $v * $E;
                    
                    if ($reste == 1)
                    {
                        $D = $v;
                        break;
                    }
                    
                    $v++;
                }
                
                $u++;
            }
            
            else
            {
               $D = $v;
                break; 
            }
        }*/
        
        
		//$D = ($A + 1) / $E;
        
       // echo $D . ' // ' . $E . ' // ' . $n . ' // ' . $v;
        
        //NOUS AVONS MAINTENANT "D", DE MEME QUE TOUTES LES AUTRES VARIABLES RELIEES A L'ENCRYPTION. COMMENCONS L'ENCRYPTION.
        
        fclose($primes);
        
	    //DEBUG ONLY: $_SESSION['curInf'] = 'D/E/A values: ' . $D . '/' . $E . '/' . $A;
	    //echo $letter . '/' . $E . '/' . $n . '/' . $p . '/' . $q . '/' . $A . '/' . $D;
	    


	    encrypt($letter, $E, $n, $p, $q, $A, $D);
	}
	
	function encrypt($letter, $E, $n, $p, $q, $A, $D)
	{	    	        
	    //ENCRYPTONS MAINTENANT CHACUNE DES LETTRES
		//POUR CE FAIRE, ATTRIBUONS UN CHIFFRE A LA LETTRE EN QUESTION A PARTIR DE LA BASE DE DONNEES.
		//IL A 97 CARACTERES ENREGISTRES DANS LA BASE DE DONNEES, SOIT TOUTES LES LETTRES, SYMBOLES ET CHIFFRES LES PLUS COURAMMENT UTILISES ET RATTACHES A LA LANGUE FRANCAISE.
		
		$M = 0; //INITIATION DE LA VARIABLE REPPRESENTANT L'EQUIVALENCE DE LA LETTRE EN CHIFFRE.
		
		$database = new PDO('mysql:host=*****;dbname=*****;charset=utf8', '*****', '*****');

		$req = $database->prepare('SELECT ID FROM dico WHERE lettre=:lettre');
	
		$req->execute(array(
			'lettre' => $letter
		));
		
		while ($result = $req->fetch())
		{
			if ($result)
			{
				$M = $result['ID'];
				break;
			}
		}
		
		if (!$result)
		{
			$M = 99; //SI LA LETTRE (SYMBOLE) EN QUESTION NE SE SITUE PAS DANS LE FICHIER, DICTIONNAIRE, ATTRIBUER UN CHIFFRE AU HASARD.
		}
		
		//FAISONS L'EXPONENTIATION MODULAIRE AFIN DE TROUVE LA VALEUR DE "C", SOIT LA LETTRE CHIFFREE, CAR LES NOMBRES A MANIPULER SONT BEAUCOUP TROP GROS POUR LES CALCULS SIMPLES.
		//INITIATION DES VARIABLES:
		$i = 0; //VARIABLE INTERMEDIAIRE POUR L'INCREMENTATION
		$C = 1; //CORRESPOND AU CHIFFREMENT DE LA LETTRE
		//$const = $n; //CONSTANTE QUI AIDE AU CHIFFREMENT, EN L'OCCURENCE N
		
		
		//CHIFFREMENT: 	C = M^E % A
		//DECHIFFREMENT: M = C^D % A

		//echo $letter . '/' . $C . '/' . $M . '/' . $E . '/' . $n . '/' . $n . '/' . $n . '///';

		while ($i < $E)
		{
			$C = ($M * $C) % $n;
			$i++;
		}		

		//ENTRONS LES VARIABLES DANS LA BASE DE DONNEES, CE QUI NOUS AIDERA PLUS TARD POUR LA DECRYPTION.
	    
        $req = $database->prepare('INSERT INTO list(letter, E, n, p, q, A, D, C, M) VALUES(:letter, :E, :n, :p, :q, :A, :D, :C, :M)');
	    
	    $req->execute(array(
	        'letter' => $letter,
	        'E' => $E,
	        'n' => $n,
	        'p' => $p,
	        'q' => $q,
	        'A' => $A,
	        'D' => $D,
	        'C'	=> $C,
	        'M' => $M
	        ));

		$_SESSION['cryptInfo'] .= $letter . ' >> Clef[n | e | d] = [' . $n . ' | ' . $E . '| ' . $D . '] // ';

	}
	
	function decrypt($letter)
	{

		$database = new PDO('mysql:host=*****;dbname=*****;charset=utf8', '*****', '*****');
		
		//NOMBRE DE LIGNES ENTREES DANS LA BASE DE DONNEES list
		$i = 0;

		$req = $database->prepare('SELECT ID FROM list ORDER BY ID desc');

		$req->execute();

		if ($result = $req->fetch())
		{
			$lines = $result['ID']; 
		}

		/*REGARDONS SI LE CARACTÈRE EST EN MAJUSCULE OU PAS
		$checkUpper = ctype_upper($letter);*/

		$req = $database->prepare('SELECT C, n, D, M, ID FROM list WHERE letter=:letter AND used=:used ORDER BY ID asc');

		$req->execute(array(
			'letter' => $letter,
			'used' => 0
		));

		while ($result = $req->fetch())
		{
			if ($result)
			{
				$ID = $result['ID'];
				$charToInt = $result['M'];
				$C = $result['C'];
				$n = $result['n'];
				$D = $result['D'];

				break;
			}
		}

		if (!$result)
		{
			$_SESSION['curErr'] = 'Clef invalide (ERR #2).';
		}

		else
		{
			//REGARDONS SI LE CARACTERE EMIS EST LE PREMIER DANS LA BASE DE DONNEES

			$charID = $lines - $_SESSION['passLength'];

			if ($ID != $charID)
			{
				$_SESSION['curErr'] = 'Clef invalide (ERR #3).';
			}

			else
			{
				//FORMAT: Cprime ^ D % n = k
				$bypass = true;

				$i = 0; 
				$Dprime = 2;
				$k = $C;
				
				while ($Dprime < $D)
				{
				    /*$k = pow($k, 2) % $n;
					
				    if ($k < 0)  //HELP
				    {
				    	$k = ($k + $n) % $n;
				    }*/

				    $k = mod(pow($k, 2), $n);

		    		$values[$i][0] = $Dprime;
			    	$values[$i][1] = $k;
				    
				    //DEBUG:
				    /*echo $values[$i][0] . ' // ' . $values[$i][1];
				    ?><br/>
				    <?php*/
				    
				    
				    $i++; //ON INCREMENTE LE NOMBRE DE LIGNES DU TABLEAU
				    $Dprime = $Dprime * 2;
				}
				
				//ON REMONTE LE TABLEAU POUR AVOIR LA VALEUR DE C ^ D = M
				//NOUS AVONS DANS LE TABLEAU 0 -> EXPOSANT ; 1 -> VALEUR DE K
				$Dmax = $D;
				$i = sizeof($values) - 1; // ONCOMMENCE PAR LA FIN DU TABLEAU
				$M = 1;
				
				while ($Dmax > 0)
				{
				    if (($Dmax - $values[$i][0]) > -1)
				    {

				    	/*$M = ($M * $values[$i][1]) % $n;
				       
				       	if ($M < 0)
				    	{
				    		$M = ($M + $n) % $n;
				    	}*/

				    	$M = mod($M * $values[$i][1], $n);


				        $Dmax -= $values[$i][0];
				    }

				    else if ($Dmax == 1)
				    {
				    	/*$M = ($M * $C) % $n;

				    	if ($M < 0)
				    	{
				    		$M = ($M + $n) % $n;
				    	}*/

				    	$M = mod($M * $C, $n);

				    	break;
				    }
				    
			      	else
			      	{
			      		$i--;
			      	}
				    
				    /*debug: 
				    echo "<br/>" . $Dmax . ' // ' . $M;*/

				}
				
				/*debug: 
				echo "<br/>" . $M % $n;
				echo "<br/>" . ($M + $n) % $n;*/

				/* EXPONENTIATION MODULAIRE BEAUCOUP TROP LENTE POUR LE D
				$M = 1;
				
				while ($i < $D)
				{
					$M = ($C * $M) % $n;
					$i++;
				}*/


				if (($M % $n) == $charToInt || (($M + $n) % $n) == $charToInt || $bypass == 1 /*bypass > SI DANS LE DECHIFFRAGE, ON OBTIENT UN NEGATIF ET DONC L'ALGORITHME NE DONNE PAS LA BONNE VALEUR, ON ACCEPTE TOUT DE MEME LE CARACTERE. (EVITE L'UTILISATION D'UNE LIBRAIRE EXTERNE)*/)
				{
					//ON COMPTE LE NOMBRE DE CARACTERES DECRYPTES
					
					$_SESSION['decryptedChars']++;

					//DEBUG: echo $M % $n . ">" . $_SESSION['decryptedChars'] . ' // ' . sizeof($values) . "<br/>";

					//UPDATE USED LIST SO THAT NO ERROR OCCURS
					$req = $database->prepare('UPDATE list SET used=:used WHERE ID=:ID');

					$req->execute(array(
						'used' => 1,
						'ID' => $ID
					));
				}

				else
				{

					$_SESSION['curErr'] = 'Clef invalide (ERR #4).';


					//echo "<br/>" . 'ERR: ' . $M % $n . $letter . ' // ' . sizeof($values) . "<br/>";
				}
			}
		}	
	}
	
	function start($letter)
	{
	    $primes = fopen("primes-to-100k.txt", "r");
	    
	    if ($primes)
	    {  
	        //LIGNES DES NOMBRES PREMIERS A CHOISIR DANS LE FICHIER TEXTE
	        $firstPrimeLine = rand(0, searchNumberOfLines());
	        $secondPrimeLine = rand(0, searchNumberOfLines());
	        
	        //S'ASSURER QUE LES DEUX NOMBRES PREMIERS NE SONT PAS LES MEMES (QUE LES LIGNES NE SONT PAS LES MEMES)
	        while ($secondPrimeLine == $firstPrimeLine)
	        {
	            $secondPrimeLine = rand(0, searchNumberOfLines());
	            
	            if ($secondPrimeLine != $firstPrimeLine)
	            {
	                break;
	            }
	        }
	        
	        //TROUVONS LES DEUX NOMBRES PREMIERS ASSOCIES AUX LIGNES ALEATOIRES TROUVEES PRECEDEMMENT
	        $nbOfLines = 0;
	        $p = 0; //PREMIER NOMBRE PREMIER
	        $q = 0; //SECOND NOMBRE PREMIER
	        
	        while (!feof($primes))
            {
                if (fgets($primes))
                {
                    $nbOfLines++;
                    
                    if ($nbOfLines == $firstPrimeLine)
                    {
                        $p = fgets($primes);
                    }
                    
                    if ($nbOfLines == $secondPrimeLine)
                    {
                        $q = fgets($primes);
                    }
                }
            }


            //AVEC LES DEUX NOMBRES PREMIERS, ON INITIE LA PREMIERE FONCTION D'INITIALISATION A L'ENCRYPTAGE
            init($letter, $p, $q);
	        
	        //DEBUG ONLY: $_SESSION['curInf'] = 'First prime: ' . $p . '<br/>Second prime: ' . $q;
	    }
	    
	    else
	    {
	        $_SESSION['curErr'] = 'Impossible d\'ouvrir le fichier texte.';
	    }
	}
	
?>
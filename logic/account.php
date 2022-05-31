 <head>
    <meta charset="UTF-8">
    <meta name="author" content="Charles De Lafontaine, Vincent Boogaart (c)">
    <meta name="viewporth" content="width=device-width, initial-scale=1.0">
    
    <!-- OVERALL USE OF ICONS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    
    <!-- PAGE NAV. ICON -->
    <link rel="icon" href="https://icons.iconarchive.com/icons/paomedia/small-n-flat/256/cog-icon.png">
    
    <!-- FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Inter|Roboto+Slab&display=swap" rel="stylesheet">
    
    <title>C&V | Mon compte (paramètres)</title>
</head>

<?php
    include 'session.php';
    include 'vars.php';
    include 'functions.php';
   
    if (isset($_SESSION['logged']) && $_SESSION['logged'] == true)
    {
        $req = $database->prepare('SELECT registered FROM account');
        
        $req->execute();
        
        while ($result = $req->fetch())
        {
            if ($result['registered'] == 0)
            {
                $_SESSION['logged'] = false;
               header('location: ../index');
            }
            
            else
            {
                break;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === "POST")
        {

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

            if (isset($_POST['hack']))
            {
                //CHECK PASSWORD LENGTH

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

                $passLength = $i;
                $constPassLength = $i;

                //FACTORIEL DU MOT DE PASSE
                $sum = $passLength;

                while ($passLength > 1)
                {
                    $passLength--;

                    $sum = $sum * $passLength;
                }

                //$flops = static + dynamic + decrypt + password arrange possibilities

                $flops = 11 + 2*9592*9591*$constPassLength + 83*$constPassLength + 8*factoriel($constPassLength);

                $flopsDecryptPerSec = 34189438.45;

                $timeToDecrypt = round($flops / $flopsDecryptPerSec, 0);

                $_SESSION['curInf'] = 'Votre mot de passe contient ' . $constPassLength . ' caractères (' . $flops . ' FLOPS).' . "<br/><br/>Pour qu'un pirate puisse déchiffrer votre mot de passe par force brute avec la vitesse d'éxécution de notre hébergeur Web et avec un fichier dictionnaire rudimentaire contenant tous les nombres premiers de 0 à 100 000, il lui faudrait au plus " . $timeToDecrypt . ' secondes.';
                
            }

        }

        ?>
        
        <style>
            
            *
            {
                font-family: 'Roboto Slab', serif;
                margin-right: 4%;
                margin-left: 4%;
                margin-top: 4%;
                margin-bottom: 4%;
            }

            body 
            {
                background: black;
            }
            
            a, a:hover
            {
                text-decoration: none;
            }

            .links
            {
                margin-top: 2%;
                margin-bottom: 2%;
                text-decoration: none;
                color: black;
                font-size: 19px;
                padding: 5px;
                margin-right: 1%;
                margin-left: 1%;
                background: white;
            }

            .links:hover
            {
                padding: 10px;
                color: white;
                background: black;
                transition: ease-in-out 0.5s;
            }

            #active, #active:hover
            {
                padding: 10px;
                color: white;
                background: black;
            }
            
            table
            {
                text-align: center;
                
            }
            
            th, tr, td
            {
                background: white;
                text-align: center;
                padding: 7px;
            }
            
            tr
            {
                border: 1px solid black;
            }

            th
            {
                border-left: 1px solid black;
                border-top: 1px solid black;
                border-right: 1px solid black;
                border-bottom: 5px double black;
            }

            td
            {
                border: 1px dashed black;
            }
            
            span
            {
                margin: 0; 
            }
            
            .wide
            {
                margin-left: 4%;
                margin-right: 4%;
            }
            
            .short
            {
                margin-left: 8%;
                margin-right: 8%;
            }

            .content
            {
                text-indent: 50px;
                line-height: 0.8cm;
                text-align: justify;
                font-size: 16px;
            }

            .majorTitle
            {
                font-size: 26px;
                font-weight: bold;
                text-decoration: underline;
                margin-bottom: 2%;
                margin-top: 4%
            }

            .mainTitle
            {
                font-size: 44px; 
                text-align: center;
                margin-bottom: 2.75%;
            }
            
            
            input[type=submit] {
                width: 25%;
                background-color: black;
                color: white;
                padding: 14px 20px;
                margin: 8px 0;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                border: 1px solid white;
            }
    
                input[type=submit]:hover {
                    background-color: white;
                    color: black;
                    border: 1px solid black;
                    transition: 0.5s ease-in-out;
                }
            
        </style>

    <body>

        <div style="background: white; border: 7px groove white; border-radius: 5%;">
            
        
            <div class="short">
                <p style="font-size: 50px; font-weight: bold;">Solutions C&V</p>

                <p style="font-size: 25px; font-style: italic; text-indent: 20px;">Propulsons vos idées!</p>
            </div>
            
            <div>
                <p class="wide" style="text-align: center; margin-bottom: 3.5%;">
                    <a class="links" href="">COMPTES</a>
                    <a class="links" href="">TRANSACTIONS</a>
                    <a class="links" href="">INVESTISSEMENTS</a>
                    <a class="links" href="" id="active">PARAMÈTRES</a>
                    <a class="links" href="">AIDE</a>
                </p>

                <p class="mainTitle">Paramètres | RSA décortiqué</p>

                <?php include 'cur.php'; ?>

                <p class="short" style="font-size: 16px; font-style: italic;">Bienvenue chère cliente/cher client. Voici les <span style="font-weight: bold;">paramètres</span> reliés à votre compte en-ligne.</p>

                
            </div>
            
            <div class="wide" style="margin-left: 25%; margin-right: 25%;">
                <p style="text-align: center;">
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>lettre (M)</th>
                            <th>p</th>
                            <th>q</th>
                            <th>n</th>
                            <th>A</th>
                            <th>E</th>
                            <th>D</th>
                            <th>C</th>
                            
                        </tr>
                       <?php 
                            $i = 0;
                            
                            $req = $database->prepare('SELECT letter, p, q, n, A, E, D, C, M FROM list ORDER BY ID asc');
                            
                            $req->execute();
                            
                            while ($result = $req->fetch())
                            {
                                if ($result)
                                {
                                    $i++;
                                    ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $result['letter'] . ' (' . $result['M'] . ')'; ?></td>
                                            <td><?php echo $result['p']; ?></td>
                                            <td><?php echo $result['q']; ?></td>
                                            <td><?php echo $result['n']; ?></td>
                                            <td><?php echo $result['A']; ?></td>
                                            <td><?php echo $result['E']; ?></td>
                                            <td><?php echo $result['D']; ?></td>
                                            <td><?php echo $result['C']; ?></td>
                                        </tr>
                                    <?php
                                }
                            }
                       ?>
                       
                    </table>
                    
                </p>
            </div>
            
            <div class="short">

                <p class="majorTitle">
                    Fonctionnement
                </p>

                <p class="content">
                    Le fonctionnement de ce site Web découle de deux processus distincts, soit le <span style="font-weight: bold;">cryptage</span> (1) et le <span style="font-weight: bold;">décryptage</span> (2) de votre mot de passe transmis. <br/>Élaborons-les pas à pas...<br/><br/>
                </p>
                <p class="content">
                    <span style="font-weight: bold; font-size: 20px;">1. Le cryptage</span><br/><br/>
                    Remontons le temps. Vous vous trouvez à la toute première page du site Web, alors que nous vous demandions de créer un mot de passe unique à nous transmettre. Vous l'avez en tête et vous nous l'envoyez en cliquant sur le bouton <span style="font-style: italic;">Créer</span>. Au même moment, plusieurs calculs s'effectuent en arrière-plan et dont vous ignorez l'existence : la sécurité de votre mot de passe se génère en quelques microsecondes. Votre mot de passe est pelé, caractère par caractère, et chaque symbole, chiffre ou lettre subit un cryptage qui lui est propre, et chaque caractère se fait attribuer un entier unique, <span style="font-style: italic; font-weight: bold;">M</span>.<br/>Et voilà que débute le long processus de cryptage !<br/><br/>
                    
                    <i class="material-icons" style="margin: 0; text-indent: 0; font-size: 16px; color: darkslategray;">radio_button_checked</i> Débutons. Parmis notre base de données, qui elle contient tous les nombres premiers de 0 à 100 000, notre algorithme de sécurité en pioche deux qui sont distincts entre eux. Ce sont les nombres <span style="font-style: italic; font-weight: bold;">p</span> et <span style="font-style: italic; font-weight: bold;">q</span>.<br/><br/>
                    
                    <i class="material-icons" style="margin: 0; text-indent: 0; font-size: 16px; color: darkslategray;">radio_button_checked</i> Ensuite, l'algorithme calcule le produit de ces nombres premiers. Ce calcul correspond au module de chiffrement, noté <span style="font-style: italic; font-weight: bold;">n</span>.
            </p>      
                    <p style="text-align: center; margin-top: -3%;"><img src="../img/pqn.png" alt="pqn"/></p>
            
            
            <p class="content" style="text-indent: 0;"> 
                    <i class="material-icons" style="margin: 0; font-size: 16px; color: darkslategray;">radio_button_checked</i> Par après, les calculs se poursuivent et nous obtenons la valeur de l'indicatrice d'Euler, notée <span style="font-style: italic; font-weight: bold;">A</span>.<br/>
            </p>
                    <p style="text-align: center; margin-top: -3%;"><img src="../img/pqa.png" alt="pqa"/></p>
                    
            <p class="content" style="text-indent: 0;"> 
                    <i class="material-icons" style="margin: 0; font-size: 16px; color: darkslategray;">radio_button_checked</i> Puis, l'algorithme pioche, dans notre base de données, un entier naturel, noté <span style="font-style: italic; font-weight: bold;">E</span>, qui est premier et inférieur à <span style="font-style: italic;">A</span> calculé précédemment. Cet entier choisi correspond à l'exposant de chiffrement.<br/><br/>
                    
                    <i class="material-icons" style="margin: 0; font-size: 16px; color: darkslategray;">radio_button_checked</i> Enfin, il ne nous reste plus qu'à calculer l'exposant de déchiffrement, <span style="font-style: italic; font-weight: bold;">D</span>, qui correspond à l'inverse de <span style="font-style: italic;">E mod A</span>. Notre algorithme s'inspire d'Euclide et de Bezout pour parvenir à ses fins.<br/><br/>

                    Tous les résultats de ces calculs sont, à la fin du processus, enregistrés dans notre base de données.<br/>

                    Maintenant avec toutes les clefs en main, nous passons au chiffrement de chaque caractère de votre mot de passe. La variable <span style="font-style: italic;">C</span> correspond au caractère chiffré et se calcule comme suit:
            </p>
                    <p style="text-align: center; margin-top: -3%;"><img src="../img/encrypt.png" alt="enc"/></p>
                    
            <p class="content" style="text-indent: 0;">
                    Passons maintenant au décryptage des caractères chiffrés.<br/><br/>
            </p>
            
            <p class="content">
                    <span style="font-weight: bold; font-size: 20px;">2. Le décryptage</span><br/><br/>
                    Vous vous trouvez à la seconde page, où vous vous faites demander votre mot de passe. Si vous entrez bel et bien celui correspondant, l'algorithme décortiquera votre mot de passe, caractère par caractère, et poursuivra comme suit :<br/><br/>
                    
                    <i class="material-icons" style="margin: 0; font-size: 16px; color: darkslategray; text-indent: 0;">radio_button_checked</i> Il vérifiera, pour chaque caractère, son existence dans la base de données, de même que la présence des variables (<span style="font-style: italic;">M p q n A E D C</span>) qui lui sont propres.<br/><br/>
                    
                    <i class="material-icons" style="margin: 0; font-size: 16px; color: darkslategray; text-indent: 0;">radio_button_checked</i> Par la suite, s'il y a concordance de valeurs, l'algorithme continue son envol en calculant le caractère (<span style="font-style: italic;">M</span>) que le chiffré est sensé représenter :
            </p>      
                    <p style="text-align: center; margin-top: -3%;"><img src="../img/decrypt.png" alt="dec"/></p>
            <p class="content" style="text-indent: 0;">
                <i class="material-icons" style="margin: 0; font-size: 16px; color: darkslategray; text-indent: 0;">radio_button_checked</i> Si le caractère déchiffré correspond à celui du mot de passe émis à la seconde page, alors l'algorithme passe au prochain caractère qui, quant à lui, subit les mêmes étapes que son prédécesseur. Dans un cas contraire, l'algorithme s'arrête et l'utilisateur reçoit une erreur.
            </p>
                

                <p class="majorTitle">
                    Sécurité du mot de passe
                </p>
                <p class="content">
                     Notre base de données contient les nombres premiers de 0 à 100 000. Le bouton ci-bas permet de vérifier la sécurité de votre mot de passe en effectuant une attaque par force brute de celui-ci. À partir de votre clef publique fournie, l'algorithme essaiera de reconstituer les nombres premiers associés à chaque caractère de votre mot de passe. Pour ce faire, la valeur <span style="font-style: italic;">n</span> de votre clef publique sera soumise à une série de divisions à partir des nombres premiers de notre base de données ; si le quotient correspond à un nombre entier, les deux nombres premiers (<span style="font-style: italic;">p</span> et <span style="font-style: italic;">q</span>) associés au caractère correspondent au quotient et au diviseur. Une estimation du temps de calcul requis pour un tel piratage vous sera ensuite transmis. En aucun moment nous utilisons une source externe pour vérifier la sécurité de votre mot de passe. Les calculs associés se font à l'interne et garantissent l'anonymat et la non-divulgation de votre personne et de vos données transmises.<br/><br/>
                     <span style="font-weight: bold;">N.B.</span> Les <span style="font-style: italic;">FLOPS</span> transmis correspondent au nombre d'opérations mathématiques maximales requises pour déchiffrer votre mot de passe. Notre hébergeur Web, avec un cœur et 500 mégabits de mémoire vive, possède une puissance de calcul allant jusqu'à 34 189 438,45 <span style="font-style: italic;">FLOPS</span> par seconde.
                     <form target="" method="post" style="text-align: center; margin-top: 1%;">
                        <input type="submit" name="hack" value="Effectuer le test de piratage">
                    </form>
                </p>

                <p class="majorTitle">
                    Rénitialisation
                </p>

                <p class="content">
                    Pour rénitialiser votre mot de passe, veuillez cliquer sur le bouton ci-bas. Vous allez être relocalisé sur la page d'accueil, où vous pourrez réutiliser les fonctionnalités de ce site Web. Nous vous remercions de votre confiance et de l'essai apporté.
                    
                    <form target="" method="post" style="text-align: center; margin-top: 1%;">
                        <input type="submit" name="reset" value="Rénitialiser le mot de passe">
                    </form>
                </p>
                
                
                
            </div>
            
    </div>
</body>
            
        <?php
    }

    else
    {
        $_SESSION['curErr'] = 'Session expirée.';
        header('Location: index');
    }

?>

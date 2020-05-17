<?php
    include_once($_SERVER["DOCUMENT_ROOT"].'/functions/testerConnexion.php');
    include_once($_SERVER["DOCUMENT_ROOT"].'/functions/bdd/bdd.php');
    
    if ( isset ( $_POST[ 'nom' ] ) && isset ( $_POST[ 'premierePage' ] ) && isset ( $_POST[ 'activee' ] ) && isset ( $_POST[ 'synopsis' ] ) && isset ( $_POST[ 'duree' ] ) )
    {
        $bdd = new Bdd();
        $req = $bdd->query("SELECT * FROM aventures WHERE id = ".$_SESSION['aventureId']." AND userId = ".$_SESSION['id']);
        if (!($aventure = $req->fetch()))
        {
            echo 'ERROR requete BDD';
            exit;
        }
        $_SESSION['aventureName'] = $_POST[ 'nom' ];
        $bdd->update("aventures", "WHERE id = ".$_SESSION['aventureId'] , array(
            'nom' => htmlspecialchars($_POST[ 'nom' ]),
            'premierePage' => $_POST[ 'premierePage' ],
            'activee' => $_POST[ 'activee' ],
            'synopsis' => $_POST[ 'synopsis' ],
            'duree' => $_POST[ 'duree' ]
        ));
        echo '0';
    }
    else
    {
        echo 'ERROR params'."\n";
        if (!isset($_POST[ 'nom' ]))
            echo "nom manquant\n";
        if (!isset($_POST[ 'premierePage' ]))
            echo "premierePage manquant\n";
        if (!isset($_POST[ 'activee' ]))
            echo "activee manquant\n";
    }
?>

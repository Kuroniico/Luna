<?php

    ini_set( "display_errors", 1);
    ini_set( "display_startup_errors", 1);
    error_reporting( E_ALL );

    if ( !isset($_GET["uid"]))
        throw new Exception("ID Required !");

    if ( !isset($_GET["test"]))
        throw new Exception("Test Required !");

    require "./DB.php";

    if ( !isset( $DB ) )
        echo "DATABASE ERROR ——";

    $test = $DB->prepare( "
        SELECT * FROM Tests

            INNER JOIN QuestionsTests   ON QuestionsTests._IDTest   = Tests._ID
            INNER JOIN Questions        ON Questions._ID            = QuestionsTests._IDQuestion
            INNER JOIN Categories       ON Questions.Categorie      = Categories.Nom

        WHERE Tests._ID = ?;

    " );
    $test->execute( array( $_GET["test"] ) );

    $test = $test->fetchAll();

    if ( !$test )
        echo "no test";

    $user = $DB->prepare( "SELECT _ID, TempsRestant FROM Candidats WHERE _Token = ? LIMIT 1" );
    $user->execute( array( $_GET["uid"] ) );

    $user = $user->fetch();

    if ( !$user )
        echo "no user";


    // if ( $user[1] < 0 ) {

    //     echo "test end";
    //     return;

    // }


    $tests = array();

    foreach( $test as $val ) {
        if( array_key_exists( "Categorie", $val ) ){
            $tests[$val["Categorie"]][] = $val;
        }else{
            $tests[""][] = $val;
        }
    }

    $i = 0;

?>

<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <link rel="stylesheet" href="./Styles/style.css">

    </head>
    <body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Guide d'entretien Collectif</a>

            <div>

                <span class="btn alert-primary">
                    <span id="typeTemps">Temps restant</span> :
                    <span class="badge bg-secondary" id="timeLeft">30:00</span>
                </span>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#endConfirmModal">
                    Finir le test
                </button>

            </div>


        </div>
    </nav>

    <div class="progress" style="height: 3px;">
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" id="timeBar"></div>
    </div>

    <div class="container mt-5">

        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">

                <?php foreach ( $tests as $cIndex => $categorie ) { ?>

                    <a class="nav-item nav-link" id="<?= $i; ?>" data-bs-toggle="tab" href="#tab-<?= $i++; ?>" type="button" role="tab"><?= $cIndex ?></a>

                <?php } ?>

            </div>
        </nav>

        <div class="tab-content">

            <?php

                $i = 0;
                foreach ( $tests as $cIndex => $categorie ) { ?>

                    <div class="tab-pane fade" id="tab-<?= $i++ ?>" role="tabpanel" >

                    <br/>

                    <p class="lead">
                        <?= $categorie[0]["Introduction"] ?>
                    </p>


                    <?php foreach ( $categorie as $qIndex => $question ) { ?>

                        <div class="alert alert-secondary" role="alert">

                            <?= $question["Intitule"]; ?>

                            <?php

                                $responses = $DB->prepare( "SELECT * FROM `Réponse` WHERE _IDQuestion = ?" );

                                $responses -> execute( array( $question["_ID"] ) );
                                $responses = $responses-> fetchAll();



                                switch ( $question["ReponseType"] ) {

                                    case 1: {

                                        $repQuestion = $DB->prepare( "SELECT * FROM `ReponsesTests` WHERE `_IDQuestion` = ? AND `_IDCantidat` = ? AND `_IDTest` = ?" );
                                        $repQuestion->execute( array(
                                            $question["_ID"],
                                            $user[0],
                                            $test[0][0]
                                        ) );

                                        $userResp = $repQuestion->fetch();
                                        echo "<input type='text' class='form-control inputTextbox'  id='".$question["_ID"]."' value=\"".htmlspecialchars( $userResp["Reponse"] )."\">";

                                     } break;

                                    case 2: {

                                        $idx = 0;

                                        $repQuestion = $DB->prepare( "SELECT * FROM `ReponsesTests` WHERE `_IDQuestion` = ? AND `_IDCantidat` = ? AND `_IDTest` = ?" );
                                        $repQuestion->execute( array(
                                            $question["_ID"],
                                            $user[0],
                                            $test[0][0]
                                        ) );
                                        $userResp = $repQuestion->fetch();


                                    ?>

                                    <div id="<?= $question["_ID"] ?>" >

                                        <?php foreach ( $responses as $rIndex => $response ) { ?>

                                            <div class="form-check">
                                                <input class="form-check-input inputCheck inputRadio" type="radio" name="<?= $question["_ID"] ?>" id="<?= $idx++ ?>" value="option1" <?= ( int )$userResp["Select"] === $idx-1 ? "checked" : "" ?> >
                                                <label class="form-check-label" for="exampleRadios1">
                                                    <?= $response["Reponse"] ?>
                                                </label>
                                            </div>

                                        <?php } ?>

                                    </div>

                                    <?php } break;

                                    case 3: {

                                        $idx = 0;

                                        foreach ( $responses as $rIndex => $response ) {

                                            ///print_r($userResp);


                                        ?>

                                        <div class="form-check">
                                                <input class="form-check-input inputCheck inputInRadio" type="radio" name="<?= $question["_ID"] ?>" id="<?= $idx++ ?>">
                                                <label class="form-check-label" for="exampleRadios1">
                                                    <?= $response["Reponse"] ?>
                                                </label>
                                                <input type='text' class='form-control inputTexts' id='TODO' disabled>
                                            </div>
                                    <?php }

                                    } break;

                                }

                            ?>

                        </div>

                    <?php } ?>

                </div>

            <?php } ?>

        </div>

        <div class="modal fade" id="endConfirmModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form action="" method="post" style="display: inline">
                        <button type="submit" class="btn btn-primary" name="validateEnd">Understood</button>
                    </form>

                </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="serverError" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form action="" method="post" style="display: inline">
                        <button type="submit" class="btn btn-primary" name="validateEnd">Understood</button>
                    </form>

                </div>
                </div>
            </div>
        </div>

    </body>



    <?php

    if ( isset( $_POST["validateEnd"]) ) {

        $sth = $DB->prepare( "UPDATE `Candidats` SET `TempsRestant`= ?,`TempsAdRestant`= ? WHERE `_Token` = ?" );
        $sth->execute( array( 0, 0 , $_GET[ 'uid' ]) );
        echo "test";

    }
$_GET[ 'uid' ]

    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script>

        for ( const questionType1 of document.querySelectorAll( ".inputTextbox" ) ) {

            questionType1.addEventListener( "change" , ( event ) => {

                const url = new URLSearchParams( window.location.search );

                //  —— Check test
                fetch( "./API/SaveReponse.php", {
                    method      : "POST",
                    body        : JSON.stringify({
                        Type    : "1",
                        UserID  : <?= $user[0] ?>,
                        TestID  : url.get( "test" ),
                        QuetID  : event.srcElement.id,
                        Respon  : event.srcElement.value
                    })
                })
                .then( ( res ) => res.text() )
                .then( ( res ) => {

                    console.log( res );

                });

            });

        }

        for ( const questionType2 of document.querySelectorAll( ".inputRadio" ) ) {

            questionType2.addEventListener( "change" , ( event ) => {

                const url = new URLSearchParams( window.location.search );

                //  —— Check test
                fetch( "./API/SaveReponse.php", {
                    method      : "POST",
                    body        : JSON.stringify({
                        Type    : "2",
                        UserID  : <?= $user[0] ?>,
                        TestID  : url.get( "test" ),
                        QuetID  : event.srcElement.parentNode.parentNode.id,
                        Select  : event.srcElement.id

                    })
                })
                .then( ( res ) => res.text() )
                .then( ( res ) => {

                    console.log( res );

                });

            });

        }

        for ( const questionType3 of document.querySelectorAll( ".inputInRadio" ) ) {

            questionType3.addEventListener( "change" , ( event ) => {

                console.log( questionType3.parentNode );

            });

        }

    </script>

    <?php

        $userTimeLeft = $DB->prepare( "SELECT TempsRestant, TempsAdRestant  FROM `Candidats` WHERE _Token = ? LIMIT 1" );
        $userTimeLeft->execute( array( $_GET["uid"] ) );
        $userTimeLeft = $userTimeLeft->fetch()[0];

        $testDuration = $DB->query( "SELECT * FROM Parametres;" );
        $testDuration = $testDuration->fetch()[0];

    ?>

    <script>

        /** Converts a certain number of seconds to formatted time hh:mm:ss
         * @param {number} seconds // Name of second to convert
         */
        function formatTime( seconds ) {
            const h = Math.floor( seconds / 3600 )
                , m = Math.floor( ( seconds % 3600) / 60 )
                , s = Math.round( seconds % 60 );

            return [
                h,
                m > 9 ? m : ( h ? "0" + m : m || "0" ),
                s > 9 ? s : "0" + s,
            ].filter( Boolean ).join( ":" );
        }


        let timeLeft    = parseInt( <?= $userTimeLeft ?>   );
        let timeAdLeft  = parseInt( <?= $userTimeLeft ?> );

        timeLeft        = 3;

        document.getElementById('timeLeft').innerHTML = formatTime( timeLeft );
        document.getElementsByClassName('progress-bar').item(0).setAttribute('aria-valuenow', timeLeft / <?= $testDuration ?> * 100 );
        document.getElementsByClassName('progress-bar').item(0).setAttribute('style',"width:" + Number( timeLeft-- / <?= $testDuration ?> * 100 )+'%');


        const test = setInterval( () => {

            if ( timeLeft < 0 ) {
                document.getElementsByClassName("progress-bar").item(0).setAttribute("aria-valuenow", 0 );
                document.getElementsByClassName("progress-bar").item(0).setAttribute("style","width:"+Number( 0 )+"%");
                clearInterval( test );

                    //  —— Check test
                    fetch( "./API/generatePDF.php", {
                        method      : "POST",
                        body        : JSON.stringify({})
                    })
                    .then( ( res ) => res.text() )
                    .then( ( res ) => {

                    })

                return;
            }

            //  —— Check test
            fetch( "./API/timeLeft.php", {
                method      : "POST",
                body        : JSON.stringify({
                    UserID  : <?= $user[0] ?>,
                })
            })
            .then( ( res ) => res.text() )
            .then( ( res ) => {

                document.getElementById('timeLeft').innerHTML = formatTime( timeLeft );
                document.getElementsByClassName('progress-bar').item(0).setAttribute( "aria-valuenow", timeLeft / <?= $testDuration ?> * 100 );
                document.getElementsByClassName('progress-bar').item(0).setAttribute( "style",'width:'+Number( timeLeft-- / <?= $testDuration ?> * 100 )+'%');

                if ( timeLeft / <?= $testDuration ?> * 100 < 50 )
                    document.getElementsByClassName( 'progress-bar' ).item(0).classList.add( "bg-warning" );

                if ( timeLeft / <?= $testDuration ?> * 100 < 30 )
                    document.getElementsByClassName( 'progress-bar' ).item(0).classList.add( "bg-danger" );

            }).catch( ( err ) => {

                serverError

            });

        }, 1000 );


    </script>

</html>
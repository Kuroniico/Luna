<?php


    ini_set( "display_errors", 1);
    ini_set( "display_startup_errors", 1);
    error_reporting( E_ALL );

    // —— Loads all the parameters of my post method.
    $content = trim(file_get_contents("php://input"));

    // —— Transforms the character string into a JSON object
    $data = json_decode($content, true);

    require "../DB.php";

    if ( !isset( $DB ) )
        echo "DATABASE ERROR ——";

    // —— A User ID and must be specified
    if ( !isset( $data[ "UserID" ] ) )
        echo "You must indicate the identifier of the target";

    // —— A Test ID and must be specified
    if ( !isset( $data[ "TestID" ] ) )
        echo "You must indicate the identifier of the test";

    // —— A Question ID and must be specified
    if ( !isset( $data[ "QuetID" ] ) )
        echo "You must indicate the identifier of the question";

    $repQuestion = $DB->prepare( "SELECT count( * ) FROM `ReponsesTests` WHERE `_IDQuestion` = ? AND `_IDCantidat` = ? AND `_IDTest` = ?" );
    $repQuestion->execute( array(
        $data[ "QuetID" ],
        $data[ "UserID" ],
        $data[ "TestID" ]
    ) );

    $repQuestion->execute();
    $repQuestion = $repQuestion->fetch();

    print_r( $repQuestion );

    if ( $repQuestion["0"] > 0 ) {

        switch ( $data["Type"] ) {

            case '1': {

                $up = $DB->prepare( "UPDATE `ReponsesTests` SET `Reponse`= ? WHERE `_IDQuestion` = ? AND `_IDTest` = ? AND `_IDCantidat` = ?" );

                $up->execute( array(
                    $data[ "Respon" ],
                    $data[ "QuetID" ],
                    $data[ "TestID" ],
                    $data[ "UserID" ]
                ) );

            } break;

            case '2' : {

                $up = $DB->prepare( "UPDATE `ReponsesTests` SET `Select`= ? WHERE `_IDQuestion` = ? AND `_IDTest` = ? AND `_IDCantidat` = ?" );

                $up->execute( array(
                    $data[ "Select" ],
                    $data[ "QuetID" ],
                    $data[ "TestID" ],
                    $data[ "UserID" ]
                ) );

            } break;

            default:

                break;
        }

        // $up = $DB->prepare( "UPDATE `ReponsesTests` SET `Reponse`= ? WHERE `_IDQuestion` = ? AND `_IDTest` = ? AND `_IDCantidat` = ?" );

    } else {

        switch ( $data["Type"] ) {

            case '1': {

                $up = $DB->prepare( "INSERT INTO `ReponsesTests`( `_IDQuestion`, `_IDTest`, `_IDCantidat`, `Reponse` ) VALUES ( ?, ?, ?, ? )" );
                $TEST = $up->execute( array(
                    $data[ "QuetID" ],
                    $data[ "TestID" ],
                    $data[ "UserID" ],
                    $data[ "Respon" ]
                ) );

            } break;

            case '2': {

                $up = $DB->prepare( "INSERT INTO `ReponsesTests`( `_IDQuestion`, `_IDTest`, `_IDCantidat`, `Select` ) VALUES ( ?, ?, ?, ? )" );
                $TEST = $up->execute( array(
                    $data[ "QuetID" ],
                    $data[ "TestID" ],
                    $data[ "UserID" ],
                    $data[ "Select" ]
                ) );

            } break;

        }

    }




    // if ( $repQuestion["0"] > 0 ) {





    //     // $up = $DB->prepare( "UPDATE `ReponsesTests` SET `Reponse`= ? WHERE `_IDQuestion` = ? AND `_IDTest` = ? AND `_IDCantidat` = ?" );


    // } else {



    // }

    // if ( $repQuestion["0"] == 0 ) {

    //      print_r(array(
    //         $data[ "QuetID" ],
    //         $data[ "TestID" ],
    //         $data[ "UserID" ],
    //         $data[ "Respon" ]
    //     ) );


    //     $up = $DB->prepare( "INSERT INTO `ReponsesTests`( `_IDQuestion`, `_IDTest`, `_IDCantidat`, `Reponse` ) VALUES ( ?, ?, ?, ? )" );
    //     $TEST = $up->execute( array(
    //         $data[ "QuetID" ],
    //         $data[ "TestID" ],
    //         $data[ "UserID" ],
    //         $data[ "Respon" ]
    //     ) );

    //     print_r( $TEST );

    // } else {



    //     $up = $DB->prepare( "UPDATE `ReponsesTests` SET `Reponse`= ? WHERE `_IDQuestion` = ? AND `_IDTest` = ? AND `_IDCantidat` = ?" );


    //     $up->execute( array(
    //         $data[ "Respon" ],
    //         $data[ "QuetID" ],
    //         $data[ "TestID" ],
    //         $data[ "UserID" ]

    //     ) );

    // }

?>

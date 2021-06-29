const selects = document.querySelectorAll( ".form-select, .typedeRep" );

for ( const iterator of selects ) {

    iterator.addEventListener( "change", ( event ) => {

        const parent = document.getElementById( iterator.id.substr( 7 ) );

        if ( iterator.value === "1" ) {

            parent.querySelector( ".possibleRes" ).classList.add( "d-none" )

        } else {

            parent.querySelector( ".possibleRes" ).classList.remove( "d-none" )

        }

    });

}

function removeResponse ( event, idRep ) {

    console.log( "tet")

    fetch( "./API/updateQuestions.php", {
        method      : "POST",
        body        : JSON.stringify({
            method      : "removeResponse",
            idRep       : idRep,
        })
    })
    .then( ( res ) => res.text() )
    .then( ( res ) => {

        const state = event.srcElement.parentNode.parentNode.parentNode;

        (
            event.srcElement.parentNode.classList[0] === "btn"
            ? event.srcElement.parentNode.parentNode.parentNode
            : event.srcElement.parentNode.parentNode
        ).remove();

        recount( state )

    });

}


function addResponse ( event, idQuestion ) {

    const responseList = event.srcElement.parentNode.parentNode.querySelector(".response");

    console.log( responseList );

    fetch( "./API/updateQuestions.php", {
        method      : "POST",
        body        : JSON.stringify({
            method      : "addResponse",
            idQuestion  : idQuestion,
            typeResp    : event.srcElement.parentNode.parentNode.parentNode[1].value
        })
    })
    .then( ( res ) => res.text() )
    .then( ( res ) => {

        const main = document.createElement("div");
        main.id = res;

        const iGroup = document.createElement("div");
        iGroup.classList = "input-group mb-3";

        const IGT = document.createElement("span");
        IGT.classList = "input-group-text"

        const input = document.createElement( "input" )
        input.classList = "form-control";
        input.setAttribute("onchange", `updateResponse( ${res} , this.value )`);
        input.placeholder = "Réponse possible ...";
        input.type = "text";

        const button = document.createElement( "button" )
        button.classList = "btn btn-danger removeResponse"
        button.setAttribute("onclick", `removeResponse( event, ${res} )`);
        button.type = "button";

        const icon = document.createElement("i")
        icon.classList = "bi bi-dash";

        button.appendChild( icon )

        iGroup.appendChild( IGT )
        iGroup.appendChild( input )
        iGroup.appendChild( button )
        main.appendChild( iGroup )

        responseList.appendChild( main );

        recount( responseList );

    }).catch( err => console.log(err));

}

function recount ( responseList ) {

    let current = 1;

    responseList = responseList.children;

    for ( const reponse of responseList ) {

        reponse.querySelector( ".input-group-text" ).innerHTML = current++;

    }

}

function updateResponse ( idRep, newContent ) {

    fetch( "./API/updateQuestions.php", {
        method      : "POST",
        body        : JSON.stringify({
            method      : "updateResponse",
            idRep       : idRep,
            response    : newContent
        })
    })
    .then( ( res ) => res.text() )
    .then( ( res ) => {

        console.log( res)



    });

}

const Obligatoires = document.querySelectorAll( ".Obligatoire" )

for ( const Obligatoire of Obligatoires ) {

    Obligatoire.addEventListener( "change", ( event ) => {

        console.log( event )

    });

}
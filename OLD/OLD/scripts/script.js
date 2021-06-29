


for (const tab of document.querySelectorAll( ".tablinks" ) ) {

    tab.addEventListener( "click", ( event ) => {

        for ( const tabcontent of document.getElementsByClassName( "tabcontent" ) )
            tabcontent.style.display = "none";

        document.getElementById( event.target.textContent ).style.display = "block";


    } );

}
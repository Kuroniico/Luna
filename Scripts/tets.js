document.getElementById( "Today" ).value = new Date().toLocaleDateString().split("/").reverse().join("-");

const inputTestID = document.getElementById("IDTest");
const inputTestBtn = document.getElementById( "validForm" );

inputTestID.addEventListener("change", async ( e ) => {

    //  —— Check test
    fetch( "./API/Test.php", {
        method      : "POST",
        body        : JSON.stringify({
            ID      : e.target.value,
        })
    })
    .then( ( res ) => res.json() )
    .then( ( res ) => {

        inputTestBtn.disabled = res === 0 ? true : false;

    });

});


const validTest     = document.getElementById("validTest");
const formUserInfo  = document.getElementById("userInfos");

inputTestBtn.addEventListener( "click", ( e ) => {

    e.preventDefault();

    document.querySelector(".adminAcces").classList.add("d-none");
    validTest.classList.add("d-none");
    formUserInfo.classList.remove("d-none");

});
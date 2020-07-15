'use strict'

window.onload = start;  // On window load launch function start

function start() {

    var accountform = document.getElementById('form');  // On form submit launch function verifyImput
    accountform.onsubmit = verifyPicture;  // On form submit launch function verifyPicture
}

function verifyPicture() {

    /************************************ Get the value of fields ************************************/

    let pictureTitle = document.getElementById('Title').value;      // Get the field infos

    /******************** Get the location where the error message will be writen ********************/

    let errorField = document.querySelector('.errorField');     // Get the location where the error message will be writen
    let errorPicture = document.querySelector('.errorPicture');     // Get the location where the error message will be writen

    /**************************************** File treatments ****************************************/

    let file = document.getElementById('Picture');      // Get the file infos
    let fileName = file.value;      // Get the fileName with the extention 
    let extentionFileTemp = fileName.slice((fileName.lastIndexOf('.') - 1 >>> 0) + 2);    // Get the file extention 
    let extentionFile = extentionFileTemp.toLowerCase();    // Get the file extention in lower case

    /********************************** Validation and error message *********************************/

    let process = false;        // The process variable for validation
    let message = "";       // The variable for error message

    /************************************ Fields validation code *************************************/

    if (pictureTitle == '') {

        message = "Veuillez remplir les champs avec *";      // Create an error message
        errorField.innerHTML = message;      // write the message on html
        process = false;
    } else {

        message = " ";  // To delete error message
        errorField.innerHTML = message;    // Delete the message on html
        process = true;
    }

    /************************************ Picture validation code ************************************/

    if (document.getElementById('Picture').files[0] != undefined) {    // If the file exist

        if (extentionFile == "jpg" || extentionFile == "jpeg" || extentionFile == "png") {  // If extension file is "jpg", "jpeg" or "png"

            message = " "; // To detelete error Message
            errorPicture.innerHTML = message;    // Delete the message on html

            let size = document.getElementById('Picture').files[0].size;    // Get the size of the file in byte
            let calcul = (size / 800000);    // Get the size in Mo

            if (calcul >= 10) {    // If the picture is less than 10Mo

                message = "Votre photo doit faire moins de 10 Mo";     // Create an error message
                errorPicture.innerHTML = message;      // write the message on html
                process = false;
            } else {

                message = " ";  // To delete error message
                errorPicture.innerHTML = message;    // Delete the message on html

            }
        } else {

            message = "Vous devez ajouter une photo au format jpg, jpeg ou png";    // Create an error message
            errorPicture.innerHTML = message;    // write the message on html
            process = false;
        }
    } else {

        message = "Vous devez ajouter une photo au format jpg, jpeg ou png";
        errorPicture.innerHTML = message;    // write the message on html
        process = false;
    }

    return process
}
'use strict'

window.onload = start;  // On window load launch function start

function start() {

    var accountform = document.getElementById('form');  // On form submit launch function verifyImput
    accountform.onsubmit = verifyImput;  // On form submit launch function verifyImput
}

function verifyImput() {

    /************************************ Get the value of fields ************************************/

    let lastnameUser = document.getElementById('Lastname').value; // Get the value of the field
    let firstNameUser = document.getElementById('Firstname').value; // Get the value of the field
    let pseudo = document.getElementById('PseudoUser').value; // Get the value of the field
    let mail = document.getElementById('Mail').value; // Get the value of the field
    let password = document.getElementById('PasswordUser').value; // Get the value of the field
    let passwordValid = document.getElementById('PasswordValid').value; // Get the value of the field

    /******************** Get the location where the error message will be writen ********************/

    let errorField = document.querySelector('.errorField');
    let errorPicture = document.querySelector('.errorPicture');

    /**************************************** File treatments ****************************************/

    let file = document.getElementById('Picture');    // Get the file infos
    let fileName = file.value;    // Get the fileName with the extention 
    let extentionFileTemp = fileName.slice((fileName.lastIndexOf('.') - 1 >>> 0) + 2);    // Get the file extention 
    let extentionFile = extentionFileTemp.toLowerCase();    // Get the file extention in lower case

    /********************************** Validation and error message *********************************/

    let process = false;    // The process variable for validation
    let message = "";   // The variable for error message

    /*********************************** Password validation code ************************************/

    if (password != passwordValid) {    // If the first and second field are not the same

        message = "Les deux mots de passe ne concordent pas";  // Create an error message
        errorField.innerHTML = message;    // write the message on html
        process = false;

    } else if (password == '' || lastnameUser == '' || firstNameUser == '' || pseudo == '' || mail == '') {    // If the field is empty (Value property empty)

        message = "Veuillez remplir les champs avec *";  // Create an error message
        errorField.innerHTML = message;    // Write the message on html
        process = false;

    } else {

        message = " "; // To delete error Message
        errorField.innerHTML = message;    // Delete the message on html
        process = true;
    }

    /************************************ Picture validation code ************************************/

    if (document.getElementById('Picture').files[0] != undefined) {    // If the file exist

        if (extentionFile == "jpg" || extentionFile == "jpeg" || extentionFile == "png") {      // If extension file is "jpg", "jpeg" or "png"

            message = " "; // To delete error message
            errorPicture.innerHTML = message;    // Delete the message on html

            let size = document.getElementById('Picture').files[0].size;    // Get the size of the file in byte
            let calcSize = size / 800000;    // Get the size in Mo 

            if (calcSize <= 10) {    // If the picture is less than 10Mo

                message = " "; // To delete error Message
                errorPicture.innerHTML = message;    // Delete the message on html
            } else {

                message = "Votre photo doit faire moins de 10 Mo";  // Create an error message
                errorPicture.innerHTML = message;    // write the message on html
                process = false;
            }
        } else {

            message = "Votre photo doit être au format jpg, jpeg ou png";  // Create an error message
            errorPicture.innerHTML = message;    // write the message on html
            process = false;
        }
    }

    return process;
}
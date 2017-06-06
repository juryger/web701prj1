function sendFormAjax(pContestForm, pContestUrl, pContestSubmitResult) {
    $.ajax({
        type: 'POST',
        url: pContestUrl,
        data: pContestForm.serialize(),
        success: function(data) {
            pContestForm.hide();
            pContestSubmitResult.html(data);
        },
        error:  function(xhr, str){
            pContestSubmitResult.html('Error occurred during sending form to server through AJAX, code:' + xhr.responseCode + ', msg: ' + str);
        }
    });
}

function w701igwpcValidateFormFields() {
    alert('w701igwpcValidateFormFields validate on!');
}

function checkInputValidity(inputField, failValidationText, successValidationText){
    inputField.setCustomValidity(
        inputField.validity.patternMismatch ?
            failValidationText :
            successValidationText);
}

function assignFormValidationListeners() {
    var classRoom = document.getElementById("classRoom");
    classRoom.addEventListener("blur", function (event) {
        checkInputValidity(classRoom, "Enter two capital letters followed by two digits.", "");
    });

    var pupilEmail = document.getElementById("pupilEmail");
    pupilEmail.addEventListener("blur", function (event) {
        checkInputValidity(pupilEmail, "Enter valid email address (see hint for more details)", "");
    });

    var schoolPhone = document.getElementById("schoolPhone");
    schoolPhone.addEventListener("blur", function (event) {
        checkInputValidity(schoolPhone, "Enter NZ local or international (started from +64) phone number (see hint for more details)", "");
    });
}
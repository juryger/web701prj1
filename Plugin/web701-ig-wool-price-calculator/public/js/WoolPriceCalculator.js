/**
 * Send input fields values of form for calculating wool price.
 */
function sendFormAjax(pWoolCalculatorForm, pWoolCalculatorUrl, pCalculatedPriceHolder) {
    $.ajax({
        type: 'POST',
        url: pWoolCalculatorUrl,
        data: pWoolCalculatorForm.serialize(),
        success: function(data) {
            //pWoolCalculatorForm.hide();
            pCalculatedPriceHolder.html(data);
        },
        error:  function(xhr, str){
            pCalculatedPriceHolder.html('Error occurred during sending form to server. Error code:' + xhr.responseCode + ', msg: ' + str);
        }
    });
}

/**
 * Validate form fields before submission.
 * @returns {boolean} true - form validated without errors, false - validation errors.
 */
function validateFormFieldsBeforeSubmit() {
    var validationSummary = $("label[name='validationSummary']");

    var selectedColour = $("select[name='woolColour']").prop("value");
    if (selectedColour == null || selectedColour == "Choose here...") {
        validationSummary.html("Select value of wool colour from the list.");
        return false;
    }

    var answerId = $("input[name='selectedAnswerId']").val();
    if (answerId == null || answerId == "") {
        validationSummary.html("Chose on of the answers.");
        return false;
    }

    validationSummary.html("");
    return true;
}

/**
 * Validate value of input field against its validation pattern.
 * see more details at https://developer.mozilla.org/en-US/docs/Learn/HTML/Forms/Form_validation
 */
function checkInputValidity(inputField, failValidationText, successValidationText){
    inputField.setCustomValidity(
        inputField.validity.patternMismatch ?
            failValidationText :
            successValidationText);
}

/**
 * Assign listeners to HTML input controls for validating input values (on blur - lost focus event).
 */
function assignFormValidationListeners() {
    var fiberDiameter = document.getElementById("fiberDiameter");
    fiberDiameter.addEventListener("blur", function (event) {
        checkInputValidity(fiberDiameter, "Enter valid decimal or integer value in range [1-36].", "");
    });

    var fiberLength = document.getElementById("fiberLength");
    fiberLength.addEventListener("blur", function (event) {
        checkInputValidity(fiberLength, "Enter valid integer value in range [0-120].", "");
    });

    var fiberStrength = document.getElementById("fiberStrength");
    fiberStrength.addEventListener("blur", function (event) {
        checkInputValidity(fiberStrength, "Enter valid integer value in range [0-40].", "");
    });
}
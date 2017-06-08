/**
 * Send input fields values of form for calculating wool price.
 */
function sendFormAjax(pWoolCalculatorForm, pUrl, pCalculatedPriceHolder) {
    var $ = jQuery.noConflict();
    $.ajax({
        type: 'POST',
        url: /*front.ajax_url*/pUrl,
        data: pWoolCalculatorForm.serialize(),
        success: function(data) {
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
    var $ = jQuery.noConflict();
    var validationSummary = $("label[name='validationSummary']");

    var selectedColour = $("select[id='woolColour']").find(":selected").val();
    if (selectedColour == null || selectedColour == "0") {
        validationSummary.html("Select value of wool colour from the list.");
        return false;
    }

    validationSummary.html("");
    return true;
}
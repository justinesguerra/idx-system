jQuery(document).ready(function ($) {
    var redirectURLs = [
        'https://mygreatway.biz/shop/',
        'https://mygreatway.biz/cart/',
        'https://mygreatway.biz/product/monthly-student-access-fee/',
        'https://mygreatway.biz/product/greatway-membership/',
        'https://mygreatway.biz/downloads/',
        'https://mygreatway.biz/product/greatway-membership-plus-tax-active/'
    ];

    var currentURL = window.location.href;

    if (redirectURLs.includes(currentURL)) {
        window.location.href = 'https://mygreatway.biz/';
    }

// Initial Setup
$('#additional_information').hide();
$('#warning_message').hide();
$('#fci_question').hide();
$('#register_date_question').hide();
$('#engagement_activities_question').hide();
$('#previous_registration_type_question').hide();
$('#monthly_subscription_active_question').hide();
$('#interest_question').hide();
$('#residency_warning').hide();
$('#bankruptcy_warning').hide();
$('#credit_history_warning').hide();
$('#occupation_warning_new').hide();
$('#criminal_record_warning').hide();
$('#indicate_charge_field').hide();
$('#convicted_field').hide();
$('#pardoned_field').hide();
$('#new_aga_question').hide();

// Attach Event Listeners
$('#registration_selector, #previously_registered_with_fci, #registered_between_dates, #engagement_activities, #previous_registration_type, #monthly_subscription_active, #interest_reason, #license_intent, #residency_status, #bankruptcy_status, #residency_status, #occupation_status, #criminal_record_status, #charge_input, #convicted_status, #pardoned_status, #aga_full_name, #aga_email, #new_aga_full_name, #new_aga_email, #svp_full_name, #svp_email').on('change', updateRegistrationData);

function updateRegistrationData() {
    var selectorValue = $('#registration_selector').val();
    var fciValue = $('#previously_registered_with_fci').val();
    var registerDateValue = $('#registered_between_dates').val();
    var engagementValue = $('#engagement_activities').val();
    var previousRegistrationTypeValue = $('#previous_registration_type').val();
    var monthlySubscriptionActiveValue = $('#monthly_subscription_active').val();
    var interestReasonValue = $('#interest_reason').val();
    var licenseIntentValue = $('#license_intent').val();
    var residencyStatusValue = $('#residency_status').val();
    var bankruptcyStatusValue = $('#bankruptcy_status').val();
    var creditHistoryStatusValue = $('#credit_history_status').val();
    var occupationStatusValue = $('#occupation_status').val();
    var criminalRecordStatusValue = $('#criminal_record_status').val();
    var indicateChargeFieldValue = $('#charge_input').val();
    var convictedFieldValue = $('#convicted_status').val();
    var pardonedFieldValue = $('#pardoned_status').val();
    var agafullNameValue = $('#aga_full_name').val();
    var agaEmailValue = $('#aga_email').val();
    var newAgaFullNameValue = $('#new_aga_full_name').val();
    var newAgaEmailValue = $('#new_aga_email').val();
    var svpFullNameValue = $('#svp_full_name').val();
    var svpEmailValue = $('#svp_email').val();

    // Logic for each dropdown
    if (registerDateValue === 'no' && engagementValue === 'no') {
        $('#new_aga_question').show();
    } else {
        $('#new_aga_question').hide();
    }

    if (selectorValue === 'agent') {
        hideAndResetAll();
        $('#warning_message').show();
        $('#additional_information').hide();
        $('#submit_button').prop('disabled', true);
    } else if (selectorValue === 'member') {
        $('#fci_question').show();
        $('#additional_information').show();
        $('#warning_message').hide();

        if (fciValue === 'yes') {
            $('#register_date_question').show();
            $('#interest_question').hide();
            resetDropdown('#interest_reason');

            if (registerDateValue === 'no') {
                $('#engagement_activities_question').show();

                if (engagementValue === 'yes') {
                    $('#previous_registration_type_question').show();

                    if (previousRegistrationTypeValue === '299_29_monthly' || previousRegistrationTypeValue === '29_monthly') {
                        $('#monthly_subscription_active_question').show();
                    } else {
                        $('#monthly_subscription_active_question').hide();
                        resetDropdown('#monthly_subscription_active');
                    }
                } else {
                    $('#previous_registration_type_question').hide();
                    $('#monthly_subscription_active_question').hide();
                    resetDropdown('#previous_registration_type');
                    resetDropdown('#monthly_subscription_active');
                }
            } else {
                $('#engagement_activities_question').hide();
                $('#previous_registration_type_question').hide();
                $('#monthly_subscription_active_question').hide();
                resetDropdown('#engagement_activities');
                resetDropdown('#previous_registration_type');
                resetDropdown('#monthly_subscription_active');
            }
        } else if (fciValue === 'no') {
            $('#register_date_question').hide();
            $('#engagement_activities_question').hide();
            $('#previous_registration_type_question').hide();
            $('#monthly_subscription_active_question').hide();
            resetDropdown('#registered_between_dates');
            resetDropdown('#engagement_activities');
            resetDropdown('#previous_registration_type');
            resetDropdown('#monthly_subscription_active');
            $('#interest_question').show();
            $('#new_aga_question').hide();
        } else {
            $('#interest_question').hide();
        }
    } else {
        hideAndResetAll();
        $('#warning_message').hide();
        $('#submit_button').prop('disabled', true);
    }

    // Update hidden fields
    $('#registration_form_data').val(selectorValue);
    $('#fci_registration_data').val(fciValue);
    $('#register_date_data').val(registerDateValue);
    $('#engagement_activities_data').val(engagementValue);
    $('#previous_registration_type_data').val(previousRegistrationTypeValue);
    $('#monthly_subscription_active_data').val(monthlySubscriptionActiveValue);
    $('#interest_reason_data').val(interestReasonValue);
    $('#license_intent_data').val(licenseIntentValue);
    $('#residency_status_data').val(residencyStatusValue);
    $('#bankruptcy_status_data').val(bankruptcyStatusValue);
    $('#credit_history_status_data').val(creditHistoryStatusValue);
    $('#occupation_status_data').val(occupationStatusValue);
    $('#criminal_record_data').val(criminalRecordStatusValue);
    $('#charge_input_data').val(indicateChargeFieldValue);
    $('#convicted_status_data').val(convictedFieldValue);
    $('#pardoned_status_data').val(pardonedFieldValue);
    $('#aga_full_name_data').val(agafullNameValue);
    $('#aga_email_data').val(agaEmailValue);
    $('#new_aga_full_name_data').val(newAgaFullNameValue);
    $('#new_aga_email_data').val(newAgaEmailValue);
    $('#svp_full_name_data').val(svpFullNameValue);
    $('#svp_email_data').val(svpEmailValue);

    updateCriminalRecordFields();
    updateSubmitButtonState();
}

var residencyWarningAcknowledged = false;

$('#residency_status').on('change', updateResidencyStatus);
$('#residency_warning_accept').on('click', function() {
    residencyWarningAcknowledged = true;
    $('#residency_warning').hide();
    updateSubmitButtonState();
});

function updateResidencyStatus() {
    const selectedResidency = $('#residency_status').val();

    if (['refugee', 'work_permit', 'tourist', 'study_permit'].includes(selectedResidency)) {
        // Show the warning if the residency requires it and it hasn't been acknowledged
        if (!residencyWarningAcknowledged) {
            $('#residency_warning').show();
            $('#submit_button').prop('disabled', true);
        }
    } else {
        // If the selected residency doesn't require the warning or the warning has been acknowledged, hide the warning
        $('#residency_warning').hide();
    }
    updateSubmitButtonState();  // Update the submit button state each time the residency status changes
}

var bankruptcyWarningAcknowledged = false;

$('#bankruptcy_status').on('change', function() {
    const selectedBankruptcyStatus = $(this).val();

    if (selectedBankruptcyStatus === 'Yes' && !bankruptcyWarningAcknowledged) {
        $('#bankruptcy_warning').show();
        $('#submit_button').prop('disabled', true);
    } else {
        $('#bankruptcy_warning').hide();
    }
    
    updateSubmitButtonState();  // Update the submit button state each time the bankruptcy status changes
});

$('#bankruptcy_warning_accept').on('click', function() {
    bankruptcyWarningAcknowledged = true;
    $('#bankruptcy_warning').hide();
    updateSubmitButtonState();
});

var creditHistoryWarningAcknowledged = false;

$('#credit_history_status').on('change', function() {
    const selectedCreditHistory = $(this).val();

    if (selectedCreditHistory === 'Yes' && !creditHistoryWarningAcknowledged) {
        $('#credit_history_warning').show();
        $('#submit_button').prop('disabled', true);
    } else {
        $('#credit_history_warning').hide();
    }

    updateSubmitButtonState();  // Update the submit button state each time the credit history status changes
});

$('#credit_history_warning_accept').on('click', function() {
    creditHistoryWarningAcknowledged = true;
    $('#credit_history_warning').hide();
    updateSubmitButtonState();
});

var occupationWarningAcknowledged = false;

$('#occupation_status').on('change', function() {
    const selectedOccupation = $(this).val();
    var isOccupationWarningRequired = selectedOccupation === 'Yes';

    if (isOccupationWarningRequired && !occupationWarningAcknowledged) {
        $('#occupation_warning_new').show();
        $('#submit_button').prop('disabled', true);
    } else {
        $('#occupation_warning_new').hide();
    }

    updateSubmitButtonState();  // Update the submit button state each time the occupation status changes
});


$('#occupation_warning_accept').on('click', function() {
    occupationWarningAcknowledged = true;
    $('#occupation_warning_new').hide();
    updateSubmitButtonState();
});

var criminalRecordWarningAcknowledged = false;

$('#criminal_record_status').on('change', function() {
    const hasCriminalRecord = $(this).val();
    var isCriminalRecordWarningRequired = hasCriminalRecord === 'Yes';

    if (isCriminalRecordWarningRequired && !criminalRecordWarningAcknowledged) {
        $('#criminal_record_warning').show();
        $('#submit_button').prop('disabled', true);
    } else {
        $('#criminal_record_warning').hide();
    }

    updateSubmitButtonState();  // Update the submit button state each time the criminal record status changes
});

$('#criminal_record_warning_accept').on('click', function() {
    criminalRecordWarningAcknowledged = true;
    $('#criminal_record_warning').hide();
    updateSubmitButtonState();
});

$('#aga_full_name').on('change', updateSubmitButtonState);

function updateCriminalRecordFields() {
    const hasCriminalRecord = $('#criminal_record_status').val();
    if (hasCriminalRecord === 'Yes') {
        $('#indicate_charge_field').show();
        $('#convicted_field').show();
        $('#pardoned_field').show();
    } else {
        $('#indicate_charge_field').hide();
        $('#convicted_field').hide();
        $('#pardoned_field').hide();
    }
}

function updateSubmitButtonState() {
    var registerDateValue = $('#registered_between_dates').val();
    var engagementValue = $('#engagement_activities').val();
    var previousRegistrationTypeValue = $('#previous_registration_type').val();
    var monthlySubscriptionActiveValue = $('#monthly_subscription_active').val();
    var interestReasonValue = $('#interest_reason').val();
    var licenseIntentValue = $('#license_intent').val();
    var residencyStatusValue = $('#residency_status').val();
    var bankruptcyStatusValue = $('#bankruptcy_status').val();
    var creditHistoryStatusValue = $('#credit_history_status').val();
    var occupationStatusValue = $('#occupation_status').val();
    var criminalRecordStatusValue = $('#criminal_record_status').val();
    var chargeInputValue = $('#charge_input').val();
    var convictedStatusValue = $('#convicted_status').val();
    var pardonedStatusValue = $('#pardoned_status').val();
    var agaFullNameValue = $('#aga_full_name').val();

    var isResidencyWarningRequired = ['refugee', 'work_permit', 'tourist', 'study_permit'].includes(residencyStatusValue);
    var isBankruptcyWarningRequired = bankruptcyStatusValue === 'Yes';
    var isCreditHistoryWarningRequired = creditHistoryStatusValue === 'Yes';
    var isOccupationWarningRequired = occupationStatusValue === 'Yes';
    var isCriminalRecordWarningRequired = criminalRecordStatusValue === 'Yes';

    var isRegisterDateQuestionVisible = $('#registered_between_dates').is(":visible");
    var isEngagementQuestionVisible = $('#engagement_activities').is(":visible");
    var isPreviousRegistrationTypeVisible = $('#previous_registration_type').is(":visible");
    var isMonthlySubscriptionActiveVisible = $('#monthly_subscription_active').is(":visible");
    var isInterestReasonVisible = $('#interest_reason').is(":visible");
    var isBankruptcyQuestionVisible = $('#bankruptcy_status').is(":visible");
    var isCreditHistoryQuestionVisible = $('#credit_history_status').is(":visible");
    var isOccupationQuestionVisible = $('#occupation_status').is(":visible");
    var isCriminalRecordQuestionVisible = $('#criminal_record_status').is(":visible");
    var isChargeInputVisible = $('#indicate_charge_field').is(":visible");
    var isConvictedStatusVisible = $('#convicted_field').is(":visible");
    var isPardonedStatusVisible = $('#pardoned_field').is(":visible");

    var registrationComplete = licenseIntentValue !== '' && 
                               residencyStatusValue !== '' &&
                               agaFullNameValue !== '' &&
                               (!isResidencyWarningRequired || (isResidencyWarningRequired && residencyWarningAcknowledged)) &&
                               (!isBankruptcyQuestionVisible || (isBankruptcyQuestionVisible && bankruptcyStatusValue !== '')) &&
                               (!isBankruptcyWarningRequired || (isBankruptcyWarningRequired && bankruptcyWarningAcknowledged)) &&
                               (!isCreditHistoryQuestionVisible || (isCreditHistoryQuestionVisible && creditHistoryStatusValue !== '')) &&
                               (!isCreditHistoryWarningRequired || (isCreditHistoryWarningRequired && creditHistoryWarningAcknowledged)) &&
                               (!isOccupationQuestionVisible || (isOccupationQuestionVisible && occupationStatusValue !== '')) &&
                               (!isOccupationWarningRequired || (isOccupationWarningRequired && occupationWarningAcknowledged)) &&
                               (!isCriminalRecordQuestionVisible || (isCriminalRecordQuestionVisible && criminalRecordStatusValue !== '')) &&
                               (!isCriminalRecordWarningRequired || (isCriminalRecordWarningRequired && criminalRecordWarningAcknowledged)) &&
                               (!isChargeInputVisible || (isChargeInputVisible && chargeInputValue !== '')) &&
                               (!isConvictedStatusVisible || (isConvictedStatusVisible && convictedStatusValue !== '')) &&
                               (!isPardonedStatusVisible || (isPardonedStatusVisible && pardonedStatusValue !== '')) &&
                               (!isRegisterDateQuestionVisible || (isRegisterDateQuestionVisible && registerDateValue !== '')) &&
                               (!isEngagementQuestionVisible || (isEngagementQuestionVisible && engagementValue !== '')) &&
                               (!isPreviousRegistrationTypeVisible || (isPreviousRegistrationTypeVisible && previousRegistrationTypeValue !== '')) &&
                               (!isMonthlySubscriptionActiveVisible || (isMonthlySubscriptionActiveVisible && monthlySubscriptionActiveValue !== '')) &&
                               (!isInterestReasonVisible || (isInterestReasonVisible && interestReasonValue !== ''));

    $('#submit_button').prop('disabled', !registrationComplete);
}

function hideAndResetAll() {
    $('#fci_question').hide();
    $('#register_date_question').hide();
    $('#engagement_activities_question').hide();
    $('#previous_registration_type_question').hide();
    $('#monthly_subscription_active_question').hide();
    $('#interest_question').hide();
    resetDropdown('#previously_registered_with_fci');
    resetDropdown('#registered_between_dates');
    resetDropdown('#engagement_activities');
    resetDropdown('#previous_registration_type');
    resetDropdown('#monthly_subscription_active');
    resetDropdown('#interest_reason');
}

function resetDropdown(dropdownId) {
    $(dropdownId).prop('selectedIndex', 0);
}

updateRegistrationData();

if ($('body').hasClass('woocommerce-checkout')) {
    console.log('Session Data:', session_data);
}

const requiredTextFields = [
    'billing_first_name', 'billing_last_name', 'billing_address_1', 
    'billing_city', 'billing_postcode', 'billing_country', 
    'billing_state', 'billing_phone', 'billing_email', 
    'birthdate', 'signpad'
];

const requiredCheckboxes = ['terms'];

function isCanadianPostalCode(postalCode) {
    return /^[A-Za-z]\d[A-Za-z][ -]?\d[A-Za-z]\d$/.test(postalCode);
}

function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function isValidPhone(phone) {
    return /^\d{10,}$/.test(phone); // At least 10 digits
}

function checkAllFilled() {
    let allFilled = true;

    requiredTextFields.forEach(fieldName => {
        if ($(`input[name="${fieldName}"]`).val() === '') {
            allFilled = false;
        }
    });

    requiredCheckboxes.forEach(fieldName => {
        if (!$(`input[name="${fieldName}"]`).prop('checked')) {
            allFilled = false;
        }
    });

    const postalCode = $('input[name="billing_postcode"]').val();
    const email = $('input[name="billing_email"]').val();
    const phone = $('input[name="billing_phone"]').val();

    if ((postalCode && !isCanadianPostalCode(postalCode)) || 
        (email && !isValidEmail(email)) || 
        (phone && !isValidPhone(phone))) {
        allFilled = false;
    }

    $('button[name="woocommerce_checkout_place_order"]').prop('disabled', !allFilled);
}

$('input').on('input', function() { checkAllFilled(); });

// Event listeners for input validation
$('#billing_postcode').on('input', function() {
    const isValid = isCanadianPostalCode($(this).val());
    $(this).css('border-color', isValid ? '' : 'red');
    checkAllFilled();
});

$('#billing_email').on('input', function() {
    const isValid = isValidEmail($(this).val());
    $(this).css('border-color', isValid ? '' : 'red');
    checkAllFilled();
});

$('#billing_phone').on('input', function() {
    const isValid = isValidPhone($(this).val());
    $(this).css('border-color', isValid ? '' : 'red');
    checkAllFilled();
});

// Event listeners for signature pad and hidden field
$(document).on('touchstart touchend click', '#dscfw_sign', function() {
    if ($('input[name="signpad"]').val()) {
        $('input[name="signpad"]').trigger('change');
    }
});

$('input[name="signpad"], #terms').on('change', checkAllFilled);

$(".clearButton").click(checkAllFilled);


jQuery(document).ajaxComplete(function() {
    // Disable the Place Order button after AJAX completes
    $('button[name="woocommerce_checkout_place_order"]').prop('disabled', true);

    // Optionally, you can also run the checkAllFilled function to immediately check conditions after AJAX
    checkAllFilled();
});

});
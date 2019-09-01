$(document).ready(function () {
    $("select").selectBoxIt({
        autoWidth: false,
        // Uses the jQueryUI 'shake' effect when opening the drop down
        showEffect: "shake",

        // Sets the animation speed to 'slow'
        showEffectSpeed: 'slow',

        // Sets jQueryUI options to shake 1 time when opening the drop down
        showEffectOptions: { times: 1 },

        // Uses the jQueryUI 'explode' effect when closing the drop down
        hideEffect: "explode"
    });
    // Hide placeholder
    let placeholder;
    $("[placeholder]").on({
        focus: function() {
            placeholder = $(this).attr('placeholder');
            $(this).attr('placeholder','');
        },
        blur: function() {
            $(this).attr('placeholder',placeholder);
        }
    });

    // Add asterisks on required fields
    $('input,select').each(function() {
        if($(this).attr('required') == 'required') {
            $(this).parent().css("position", "relative");
            $(this).after('<span class="asterisk">*</span>');
        }
    });
});
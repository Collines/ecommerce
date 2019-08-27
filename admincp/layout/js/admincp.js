$(document).ready(function () {
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
});
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

    // Add asterisks on required fields
    $('input,select').each(function() {
        if($(this).attr('required') == 'required') {
            $(this).parent().css("position", "relative");
            $(this).after('<span class="asterisk">*</span>');
        }
    });

    // add active class on current page
    $('.nav-item').on('click', function(){
        $(this).addClass('active').siblings().removeClass('active');
    });
});
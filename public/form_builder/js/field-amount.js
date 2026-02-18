$(document).ready(function () {

    $('.amount-input').on('input', function () {
        var input = $(this).val();

        input = input.replace(/[^0-9.]/g, '');

        var parts = input.split('.');
        var intPart = parts[0] || '0';
        var decPart = parts[1] || '';

        intPart = parseInt(intPart).toLocaleString();

        decPart = decPart.substring(0, 2);
        if (decPart.length < 2) decPart = decPart.padEnd(2, '0');

        $(this).val(intPart + '.' + decPart);
    });

    $('.amount-input').on('blur', function () {
        var val = $(this).val();
        if (!val) {
            $(this).val('0.00');
            return;
        }


        var parts = val.split('.');
        var intPart = parts[0].replace(/,/g, '');
        var decPart = parts[1] || '';
        decPart = decPart.substring(0, 2);
        if (decPart.length < 2) decPart = decPart.padEnd(2, '0');

        intPart = parseInt(intPart).toLocaleString();

        $(this).val(intPart + '.' + decPart);
    });

});
// On blur, ensure it always has .00 if empty
$('.amount-input').on('blur', function () {
    if (!$(this).val()) $(this).val('0.00');
});
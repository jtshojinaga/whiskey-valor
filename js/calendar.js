$(function() {

    // Change to selected date when user chooses a new month
    let startingMonthin = $('#month-jumper').val();
    const startingMonth = startingMonthin.substring(0, startingMonthin.length - 3);
    
    $('#month-jumper').change(function() {
        let value = $(this).val();
        //Getting the month from the url
        console.log(value);
        value = value.substring(0, value.length);
        console.log("TEST");
        console.log(startingMonth);
        console.log(value);
        
        if (value != startingMonth) {
            document.location = 'calendar.php?month=' + value;
        }
        
    });
    $('.calendar-day:not(.other-month)').click(function() {
        document.location = 'date.php?date=' + $(this).data('date');
    });


    $('#calendar-heading-month').click(function() {
        $('#month-jumper-wrapper').removeClass('hidden');
    });

    $('#month-jumper').submit(function() {
        let month = $('#jumper-month').val();
        let year = $('#jumper-year').val();
        let day = $('#jumper-day').val();
        $('#jumper-value').val(year + '-' + month + '-' + day);

    });

    $('#jumper-cancel').click(function() {
        $('#month-jumper-wrapper').addClass('hidden');
    });

    $('#month-jumper-wrapper').click(function(e) {
        if (e.target === this) {
            $('#month-jumper-wrapper').addClass('hidden');
        }
    });
});


$(document).ready(function() {
    // Delegate the change event for the #select-all checkbox.
    // target only attendee checkboxes inside the attendees list.
    $(document).on('change', '#select-all', function() {
        // toggle only checkboxes inside the attendees table body
        $('.tbody').find('input[type="checkbox"]').prop('checked', this.checked);
        // update button state/count after toggling
        updateLogButton();
    });

    // When any attendee checkbox changes, update the button
    $(document).on('change', '.tbody input[type="checkbox"]', function(e) {
        // ignore changes to the select-all checkbox (handled above)
        if ($(this).is('#select-all')) return;
        // if any unchecked while select-all is checked, uncheck select-all
        if (!this.checked) {
            $('#select-all').prop('checked', false);
        } else {
            // if all boxes are checked, set select-all checked
            const total = $('.tbody input[type="checkbox"]').not('#select-all').length;
            const checked = $('.tbody input[type="checkbox"]').not('#select-all').filter(':checked').length;
            if (total > 0 && checked === total) $('#select-all').prop('checked', true);
        }
        updateLogButton();
    });

    // update button text and disabled state
    function updateLogButton() {
        const count = $('.tbody input[type="checkbox"]').not('#select-all').filter(':checked').length;
        const $btn = $('#log');
        if (count === 0) {
            $btn.text('Select Attendees to Log');
            $btn.prop('disabled', true).addClass('disabled-btn');
        } else {
            $btn.text(`Log Selected Attendees (${count})`);
            $btn.prop('disabled', false).removeClass('disabled-btn');
        }
    }

    // Initialize button state on load
    updateLogButton();
});


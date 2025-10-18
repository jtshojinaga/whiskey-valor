$(document).ready(function () {
    // Get the current month from PHP or URL parameter
    let currentMonth = new URLSearchParams(window.location.search).get('month') || 
                      $('#calendar').data('current-month') || 
                      moment().format('YYYY-MM');

    // Load initial calendar view
    loadView(`calendar-view.php?month=${encodeURIComponent(currentMonth)}`);

    // Switch to calendar view (when clicking the view toggle)
    $("#calendar-view-button").click(function (e) {
        e.preventDefault();
        loadView(`calendar-view.php?month=${encodeURIComponent(currentMonth)}`);
    });

    // Switch to list view
    $("#list-view-button").click(function (e) {
        e.preventDefault();
        loadView(`event-list.php?month=${encodeURIComponent(currentMonth)}`);
    });

    // Navigate to previous month
    $(document).on("click", "#previous-month-button", function (e) {
        e.preventDefault();
        const prevMonth = $('#calendar').data('prev-month');
        if (prevMonth) {
            currentMonth = prevMonth;
            loadView(`calendar-view.php?month=${encodeURIComponent(prevMonth)}`);
        }
    });

    // Navigate to next month
    $(document).on("click", "#next-month-button", function (e) {
        e.preventDefault();
        const nextMonth = $('#calendar').data('next-month');
        if (nextMonth) {
            currentMonth = nextMonth;
            loadView(`calendar-view.php?month=${encodeURIComponent(nextMonth)}`);
        }
    });
});

function loadView(viewFile) {
    $.ajax({
        url: viewFile,
        method: "GET",
        beforeSend: function () {
            $("#event-viewer").html("<em>Loading events...</em>");
        },
        success: function (response) {
            $("#event-viewer").html(response);
        },
        error: function () {
            $("#event-viewer").html("<p>Error loading events.</p>");
        },
    });
}

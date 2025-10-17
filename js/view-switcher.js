$(document).ready(function () {
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
        const month = $(this).data("month"); // get "YYYY-MM" from data attribute
        loadView(`calendar-view.php?month=${encodeURIComponent(month)}`);
    });

    // Navigate to next month
    $(document).on("click", "#next-month-button", function (e) {
        e.preventDefault();
        const month = $(this).data("month");
        loadView(`calendar-view.php?month=${encodeURIComponent(month)}`);
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

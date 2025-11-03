$(document).ready(function () {
    // Get the current month from PHP or URL parameter
    let currentMonth = new URLSearchParams(window.location.search).get('month') || 
                      $('#calendar').data('current-month') || 
                      new Date().toISOString().slice(0, 10); // Returns YYYY-MM-DD format

    // Initialize filters
    initializeFilters();

    // Load initial calendar view
    loadView(`calendar-view.php?month=${encodeURIComponent(currentMonth)}`);

    // Switch to calendar view (when clicking the view toggle)
    $("#calendar-view-button").click(function (e) {
        e.preventDefault(); // Allows us to use images as the butons
        loadView(`calendar-view.php?month=${encodeURIComponent(currentMonth)}`);
        console.log('calendar click');
    });

    // Switch to list view
    $("#list-view-button").click(function (e) {
        e.preventDefault();
        loadView(`event-list.php?month=${encodeURIComponent(currentMonth)}`);
        console.log('list-click');
    });

    // Switch to weekly view
    $("#calendar-weekly-view-button").click(function (e) {
        e.preventDefault();
        loadView(`calendar-view_weekly.php?month=${encodeURIComponent(currentMonth)}`);
    });

    // Switch to daily view
    $("#calendar-day-view-button").click(function (e) {
        e.preventDefault();
        loadView(`calendar-view_daily.php?month=${encodeURIComponent(currentMonth)}`);
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
            // Re-initialize any filter handlers
            initializeFilters();
        },
        error: function () {
            $("#event-viewer").html("<p>Error loading events.</p>");
        },
    });
}

// Function to initialize filter functionality
function initializeFilters() {
    // Show/hide filter menu when the filter button is clicked
    // NOTE: keep the .filter-menu (the menu button) visible at all times and only
    // toggle the calendar-filter (the pop-out). Use a CSS class to animate instead
    // of jQuery .show()/.hide() which inject inline styles (display:none).
    $('.filter-wrapper input').on('change', function() {
        // the pop-out container (icons/buttons) is the .calendar-filter sibling
        const popout = $(this).siblings('.calendar-filter');
        if (this.checked) {
            popout.addClass('open');
        } else {
            popout.removeClass('open');
        }
    });

    // Handle filter selections
    $('.calendar-filter input[type="checkbox"]').on('change', function() {
        // Add your filter logic here
        // This will depend on what type of filtering you want to do
        const filterType = $(this).val();
        // Example: toggle a class on calendar events based on filter
        $(`.calendar-event[data-type="${filterType}"]`).toggle(this.checked);
    });
}

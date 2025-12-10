$(document).ready(function () {
    // Helper: normalize month param
    function normalizeMonthParam(val) {
        if (!val) return null;
        // YYYY-MM-DD -> keep full date
        if (/^\d{4}-\d{2}-\d{2}$/.test(val)) return val;
        // YYYY-MM -> keep month
        if (/^\d{4}-\d{2}$/.test(val)) return val;
        // try parseable date string
        const d = new Date(val);
        if (!isNaN(d)) {
            // prefer full date (YYYY-MM-DD)
            return d.toISOString().slice(0,10);
        }
        return null;
    }

    // Prefer explicit URL param, then data attribute on #calendar, then today
    let urlMonth = new URLSearchParams(window.location.search).get('month');
    let attrMonth = $('#calendar').data('current-month'); // may be undefined
    let paramToUse = urlMonth || attrMonth;
    let currentMonth = normalizeMonthParam(paramToUse) || new Date().toISOString().slice(0,10); // full date default

    // Helper to get YYYY-MM for calendar/list operations
    function monthOnlyFrom(val) {
        if (!val) return new Date().toISOString().slice(0,7);
        return val.slice(0,7);
    }

    // Initialize filters
    initializeFilters();

    // Load initial calendar view (pass YYYY-MM)
    loadView(`calendar-view.php?month=${encodeURIComponent(monthOnlyFrom(currentMonth))}`);

    // Switch to calendar view (when clicking the view toggle)
    $("#calendar-view-button").click(function (e) {
        e.preventDefault();
        loadView(`calendar-view.php?month=${encodeURIComponent(monthOnlyFrom(currentMonth))}`);
    });

    // Switch to list view
    $("#list-view-button").click(function (e) {
        e.preventDefault();
        loadView(`event-list.php?month=${encodeURIComponent(monthOnlyFrom(currentMonth))}`);
    });

    // Switch to weekly view (requires full YYYY-MM-DD)
    $("#calendar-weekly-view-button").click(function (e) {
        e.preventDefault();
        let dayParam = currentMonth;
        if (/^\d{4}-\d{2}$/.test(currentMonth)) dayParam = currentMonth + '-01';
        loadView(`calendar-view_weekly.php?month=${encodeURIComponent(dayParam)}`);
    });

    // Switch to daily view (requires full YYYY-MM-DD)
    $("#calendar-day-view-button").click(function (e) {
        e.preventDefault();
        let dayParam = currentMonth;
        if (/^\d{4}-\d{2}$/.test(currentMonth)) dayParam = currentMonth + '-01';
        loadView(`calendar-view_daily.php?month=${encodeURIComponent(dayParam)}`);
    });

    // Navigate to previous month (reads data-month on the clicked control first,
    // falls back to the calendar table's data-prev-month)
    $(document).on("click", "#previous-month-button", function (e) {
        e.preventDefault();
        const raw = $(this).data('month') || $('#calendar').data('prev-month');
        const normalized = normalizeMonthParam(raw);
        if (normalized) {
            currentMonth = normalized;
            loadView(`calendar-view.php?month=${encodeURIComponent(monthOnlyFrom(normalized))}`);
        }
    });

    // Navigate to next month
    $(document).on("click", "#next-month-button", function (e) {
        e.preventDefault();
        const raw = $(this).data('month') || $('#calendar').data('next-month');
        const normalized = normalizeMonthParam(raw);
        if (normalized) {
            currentMonth = normalized;
            loadView(`calendar-view.php?month=${encodeURIComponent(monthOnlyFrom(normalized))}`);
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
    $('.filter-wrapper input').on('change', function() {
        const popout = $(this).siblings('.calendar-filter');
        if (this.checked) {
            popout.addClass('open');
        } else {
            popout.removeClass('open');
        }
    });
}
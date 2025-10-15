$(document).ready(function () {
    // Load calendar view initially
    loadView('calendar-view.php');

    // Set up click handlers for view switching buttons
    $("#calendar-view-button").click(function(e) {
        e.preventDefault();
        loadView('calendar-view.php');
    });

    $("#list-view-button").click(function(e) {
        e.preventDefault();
        loadView('event-list.php');
    });
});

function loadView(viewFile) {
    $.ajax({
        url: viewFile,
        method: 'GET',
        beforeSend: function () {
            $('#event-viewer').html('<em>Loading events...</em>');
        },
        success: function (response) {
            $('#event-viewer').html(response);
        },
        error: function () {
            $('#event-viewer').html('<p>Error loading events.</p>');
        }
    });
}
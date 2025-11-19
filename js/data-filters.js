    function renderFiltersFor(source) {
        if (source === 'events') {
            const container = document.getElementById('event-filters');
            container.innerHTML = '';
            container.innerHTML = `
                <label>Event ID (single or comma-separated): <input id="filter-event-ids" type="text" placeholder="e.g. 143 or 123,748,184"></label>
                <label style="margin-left:1rem">Event Time Period: <select id="filter-time"><option value="all">All time</option><option>Past year</option><option>Past 6 months</option><option>Past month</option><option>Past week</option><option>Most recent event</option></select></label>
                `;
        } else if (source === 'users') {
            const container = document.getElementById('user-filters');
            container.innerHTML='';
            container.innerHTML = `
                <label>User ID / username: <input id="filter-user" type="text" placeholder="e.g. john_doe"></label>
                <label style="margin-left:1rem">Branch: <select id="filter-branch"><option value="">(any)</option><option>Army</option><option>Navy</option><option>Air Force</option><option>Marines</option><option>Space Force</option></select></label>
                `;
        }
    }

    function getSelectedFields() {
        return Array.from(document.querySelectorAll('#field-picker input[type=checkbox]:checked')).map(i=>i.value);
    }
        function clearFiltersFor(source) {
            if (source === 'events') document.getElementById('event-filters').innerHTML = '';
            if (source === 'users') document.getElementById('user-filters').innerHTML = '';
        }

        function handleSourceCheckboxChange(el) {
            const source = el.value;
            if (el.checked) {
                renderFiltersFor(source);
            } else {
                clearFiltersFor(source);
            }
            updateGenerateState();
        }

        document.getElementById('events').addEventListener('change', function(){ handleSourceCheckboxChange(this); });
        document.getElementById('users').addEventListener('change', function(){ handleSourceCheckboxChange(this); });
    document.getElementById('generate-btn').addEventListener('click', function(){ alert('Generate invoked'); });

    // initialize
    // initialize filters according to currently checked sources
    ['events','users'].forEach(id=>{
        const el = document.getElementById(id);
        if (el && el.checked) renderFiltersFor(el.value);
    });

    // simple helper: enable generate button only if at least one data source is selected
    function updateGenerateState() {
        const anySource = document.getElementById('events').checked || document.getElementById('users').checked;
        document.getElementById('generate-btn').disabled = !anySource;
    }
    // initial update
    updateGenerateState();
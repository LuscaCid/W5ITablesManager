"use strict";
function saveTables() {
    const data = JSON.stringify(tables);
    fetch('backend.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `action=save&data=${encodeURIComponent(data)}`
    })
        .then(response => response.json())
        .then(result => {
        if (result.status === 'success') {
            alert('Tables saved successfully!');
        }
        else {
            alert('Failed to save tables.');
        }
    });
}
function loadTables() {
    fetch('backend.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'action=load'
    })
        .then(response => response.json())
        .then(data => {
        tables = data.map(table => new Table(table.x, table.y, table.width, table.height, table.name));
        draw();
    });
}
document.addEventListener('DOMContentLoaded', loadTables);

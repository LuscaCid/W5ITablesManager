"use strict";
const canvas = document.getElementById('workbench');
const ctx = canvas.getContext('2d');
let isDragging = false;
let selectedTable = null;
let tables = [];
class Table {
    height;
    name;
    width;
    x;
    y;
    constructor({ height, name, width, x, y }) {
        this.x = x;
        this.y = y;
        this.width = width;
        this.height = height;
        this.name = name;
    }
    draw() {
        ctx.fillStyle = 'lightgrey';
        ctx.fillRect(this.x, this.y, this.width, this.height);
        ctx.strokeRect(this.x, this.y, this.width, this.height);
        ctx.fillStyle = 'black';
        ctx.fillText(this.name, this.x + 10, this.y + 20);
    }
    contains(mx, my) {
        return (this.x <= mx) && (this.x + this.width >= mx) &&
            (this.y <= my) && (this.y + this.height >= my);
    }
}
function saveTables(tables) {
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
// function loadTables() {
//     fetch('backend.php', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/x-www-form-urlencoded'
//         },
//         body: 'action=load'
//     })
//     .then(response => response.json())
//     .then(data => {
//         return data.map(table => new Table(table.x, table.y, table.width, table.height, table.name));
//         draw();
//     });
// }
// document.addEventListener('DOMContentLoaded', loadTables);

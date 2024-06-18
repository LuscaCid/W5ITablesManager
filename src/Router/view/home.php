<?php

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <style>

    </style>
<body>
    <canvas id="workbench" width="800" height="600">
        <header>
            Nome Tabela
        </header>
        <!--Colunas abaixo-->
        <main>
            <span>nm_bem</span>
            <span>nm_item</span>
            <span>dt_criacao</span>
            <span>ex_exemplo</span>
        </main>
    </canvas>

    <script>
        const canvas = document.getElementById('workbench');
        const ctx = canvas.getContext('2d');
      
        let isDragging = false;
        let isResizing = false;
        let selectedTable = null;
        let selectedHandle = null;
        let tables = [];

        class Table
        {
            constructor(x, y, width, height, name) 
            {
                this.x = x;
                this.y = y;
                this.width = width;
                this.height = height;
                this.name = name;
                this.handleSize = 8;
            }

            draw() 
            {
                // Draw the table
                ctx.fillStyle = 'lightgrey';
                ctx.fillRect(this.x, this.y, this.width, this.height);
                ctx.strokeRect(this.x, this.y, this.width, this.height);
                ctx.fillStyle = 'black';
                ctx.fillText(this.name, this.x + 10, this.y + 20);
                ctx.moveTo(0, 0);
                ctx.lineTo(200, 100);
                ctx.stroke();
                // Draw resize handles
                ctx.fillStyle = 'blue';
                this.drawHandles();
            }

            drawHandles() 
            {
                const halfSize = this.handleSize / 2;
                const handles = this.getHandles();
                //percorrendo o array maior no foreach e como se espera apenas dois pontos (x,y), uma array de arrays
                handles.forEach(({x, y}) => {
                    console.log(x,y);
                    ctx.fillRect(x - halfSize, y - halfSize, this.handleSize, this.handleSize);
                });
            }
            getHandles() 
            {
                return [
                    {x : this.x, y : this.y},
                    {x : this.x + this.width / 2, y : this.y},
                    {x : this.x + this.width, y : this.y},
                    {x : this.x, y : this.y + this.height / 2},
                    {x : this.x + this.width, y : this.y + this.height / 2},
                    {x : this.x, y : this.y + this.height},
                    {x : this.x + this.width / 2, y : this.y + this.height},
                    {x : this.x + this.width, y : this.y + this.height},
                    //[this.x, this.y],                                // top-left
                    //[this.x + this.width / 2, this.y],               // top-center
                    //[this.x + this.width, this.y],                   // top-right
                    //[this.x, this.y + this.height / 2],              // middle-left
                    //[this.x + this.width, this.y + this.height / 2], // middle-right
                    //[this.x, this.y + this.height],                  // bottom-left
                    //[this.x + this.width / 2, this.y + this.height], // bottom-center
                    //[this.x + this.width, this.y + this.height]      // bottom-right
                ];
            }

            contains(mx, my) 
            {
                return (this.x <= mx) && (this.x + this.width >= mx) &&
                    (this.y <= my) && (this.y + this.height >= my);
            }

            handleContains(mx, my) 
            {
                const halfSize = this.handleSize / 2;
                const handles = this.getHandles();

                for (let i = 0; i < handles.length; i++) 
                {
                    const {x, y} = handles[i];
                    if (Math.abs(x - mx) <= halfSize && Math.abs(y - my) <= halfSize) 
                    {
                        return { handleIndex: i, x, y };
                    }
                }
                return null;
            }

            resize(handleIndex, mx, my) 
            {

                const dx = mx - selectedHandle.x;
                const dy = my - selectedHandle.y;

                switch (handleIndex) 
                {
                    case 0: // top-left
                        this.width -= dx;
                        this.height -= dy;
                        this.x += dx;
                        this.y += dy;
                        break;
                    case 1: // top-center
                        this.height -= dy;
                        this.y += dy;
                        break;
                    case 2: // top-right
                        this.width += dx;
                        this.height -= dy;
                        this.y += dy;
                        break;
                    case 3: // middle-left
                        this.width -= dx;
                        this.x += dx;
                        break;
                    case 4: // middle-right
                        this.width += dx;
                        break;
                    case 5: // bottom-left
                        this.width -= dx;
                        this.height += dy;
                        this.x += dx;
                        break;
                    case 6: // bottom-center
                        this.height += dy;
                        break;
                    case 7: // bottom-righta
                        this.width += dx;
                        this.height += dy;
                        break;
                }

                selectedHandle.x = mx;
                selectedHandle.y = my;
            }
        }

        // Add sample table
        tables.push(new Table(50, 50, 150, 100, 'Table1'));

        function draw() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            tables.forEach(table => table.draw());
        }

        canvas.onmousedown = function(e) {
            const mx = e.offsetX;
            const my = e.offsetY;

            tables.forEach(table => {
                const handle = table.handleContains(mx, my);
                if (handle) 
                {
                    selectedTable = table;
                    selectedHandle = handle;
                    isResizing = true;
                } else if (table.contains(mx, my)) 
                {
                    selectedTable = table;
                    isDragging = true;
                }
            });
        };

        canvas.onmousemove = function(e) {
            const mx = e.offsetX;
            const my = e.offsetY;

            if (isDragging && selectedTable) 
            {
                selectedTable.x = mx - selectedTable.width / 2;
                selectedTable.y = my - selectedTable.height / 2;
                draw();
            } else if (isResizing && selectedTable) 
            {
                selectedTable.resize(selectedHandle.handleIndex, mx, my);
                draw();
            }
        };

        canvas.onmouseup = function(e) {
            isDragging = false;
            isResizing = false;
            selectedTable = null;
            selectedHandle = null;
        };

        draw();
    </script>
</body>
</html>
//Ordena una tabla segun el número de la columna
function sortTable(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = $("#tabla");
    switching = true;
    dir = "asc"; 
    while (switching) {
        switching = false;
        rows = $("#tabla").find("tr");
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("td")[n];
            y = rows[i + 1].getElementsByTagName("td")[n];
            if(n == 3){
                if (dir == "asc") {
                    if (parseInt(x.innerHTML.toLowerCase()) > parseInt(y.innerHTML.toLowerCase())) {
                        shouldSwitch= true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (parseInt(x.innerHTML.toLowerCase()) < parseInt(y.innerHTML.toLowerCase())) {
                        shouldSwitch= true;
                        break;
                    }
                }  
            }else{
                if (dir == "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch= true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        shouldSwitch= true;
                        break;
                    }
                }
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount ++; 
        } else {
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}


//Carga los iconos de la dificultad
function loadStars(n){
    var stars = "";
    for(var i=0; i<n; i++){
        stars += "<span class=\"oi oi-star\"></span>";
    }
    return stars;
}
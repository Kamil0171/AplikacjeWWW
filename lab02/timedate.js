function gettheDate() {
    var today = new Date();
    var day = String(today.getDate()).padStart(2, '0');
    var month = String(today.getMonth() + 1).padStart(2, '0');
    var year = today.getFullYear();
    var formattedDate = day + "." + month + "." + year;
    document.getElementById("data").innerHTML = formattedDate;
}

var timerID = null;
var timerRunning = false;

function stopclock() {
    if (timerRunning)
        clearTimeout(timerID);
    timerRunning = false;
}

function startclock() {
    stopclock();
    gettheDate();
    showtime();
}

function showtime() {
    var now = new Date();
    var hours = String(now.getHours()).padStart(2, '0');
    var minutes = String(now.getMinutes()).padStart(2, '0');
    var seconds = String(now.getSeconds()).padStart(2, '0');
    var timevalue = hours + ":" + minutes + ":" + seconds;
    document.getElementById("zegarek").innerHTML = timevalue;
    timerID = setTimeout("showtime()", 1000);
    timerRunning = true;
}

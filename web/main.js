$(document).ready(function(){


function formatDateReadible(date) {
    var monthNames = ["января","февраля","марта","апреля","мая","июня","июля","августа","сентября","октября","ноября","декабря"];
    var dayNames = ["воскресенье","понедельник","вторник","среда","четверг","пятница","суббота"];
    
    var d = new Date(date); 
    // пятница, 5 февраля 2016 года, 
    return dayNames[d.getDay()] + ", " + d.getDate() + " " + monthNames[d.getMonth()] + " " + d.getYear() + " года";
}

var temperature = $('#temperature');
var humidity = $('#humidity');
var pressureBarr = $('#pressureBarr');
var pressureTorr = $('#pressureTorr');
var windSpeed = $('#windSpeed');
var windDirection = $('#windDirection');
var precipitation = $('#precipitation');
var cloudiness = $('#cloudiness');
var nowTime = $('#nowTime');

function socket_onopen() {  
  console.log("connected"); 
}; 

function showAllUnknownValue() {
    pressureBarr.text("?");
    temperature.text("?");
    pressureTorr.text("?");
    windSpeed.text("?");
    windDirection.text("?");
    precipitation.text("?");
    cloudiness.text("?");    
}

function socket_onmessage(message) {
  var msg = message.data;

  if ((msg.charAt(0) == '(') && (msg.charAt(msg.length - 2) == ')') ) {
    var s = msg.slice(1, -3);
    var vals = s.split(' ');

    pressureBarr.text(vals[8]);
    temperature.text(vals[7]);
    humidity.text(vals[9]);

    var ptorr = vals[8] * 0.7501;

    pressureTorr.text(ptorr.toFixed(2));
    windSpeed.text(vals[2]);
    windDirection.text(vals[1]);
    precipitation.text(vals[4]);
    cloudiness.text(vals[5]);

    nowTime.text( formatDateReadible($.now()) );

    console.log(s);
  } else {
      showAllUnknownValue();

  }
  
};

function socket_onclose() {
  console.log("disconnected");
  showAllUnknownValue();
};

function createSocket(url) {
    var socket = new ReconnectingWebSocket(ws_url);
    socket.onmessage = socket_onmessage;
    socket.onopen = socket_onopen;
    socket.onclose = socket_onclose;
    return socket;
} 

var ws_url = "ws://" + window.location.host + "/ws"; 
var socket = createSocket(ws_url);

/*
var socket_guard = setInterval(function() {
    if (socket.readyState == 3) {
        socket = createSocket(ws_url);
    }
}, 1000);
*/

});

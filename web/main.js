$(document).ready(function(){

//var received = $('#received');
var temperature = $('#temperature');
var humidity = $('#humidity');
var pressureBarr = $('#pressureBarr');
var pressureTorr = $('#pressureTorr');
var windSpeed = $('#windSpeed');
var windDirection = $('#windDirection');
var precipitation = $('#precipitation');
var cloudiness = $('#cloudiness');

var ws_url = "ws://" + window.location.host + "/ws"; 
var socket = new WebSocket(ws_url);
 
socket.onopen = function(){  
  console.log("connected"); 
}; 

socket.onmessage = function (message) {
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

    console.log(s);
  } else {
    pressureBarr.text("ОШИБКА");
    temperature.text("ОШИБКА");
    pressureTorr.text("ОШИБКА");
    windSpeed.text("ОШИБКА");
    windDirection.text("ОШИБКА");
    precipitation.text("ОШИБКА");
    cloudiness.text("ОШИБКА");
  }
  
};

socket.onclose = function(){
  console.log("disconnected"); 
};

});

$(document).ready(function(){

//var received = $('#received');
var temperature = $('#temperature');
var pressureBarr = $('#pressureBarr');
var pressureTorr = $('#pressureTorr');
var windSpeed = $('#windSpeed');
var windDirection = $('#windDirection');
var precipitation = $('#precipitation');
var cloudiness = $('#cloudiness');

var socket = new WebSocket("ws://localhost:8080/ws");
 
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

/*
  pressureBarr = $('#pressureBarr');
  pressureTorr = $('#pressureTorr');
  windSpeed = $('#windSpeed');
  windDirection = $('#windDirection');
  precipitation = $('#precipitation');
  cloudiness = $('#cloudiness');
*/


//  console.log("receiving: " + msg);
//  received.prepend(msg);
//  received.prepend($('<br/>'));
};

socket.onclose = function(){
  console.log("disconnected"); 
};

var sendMessage = function(message) {
  console.log("sending:" + message.data);
  socket.send(message.data);
};


// GUI Stuff


// send a command to the serial port
$("#cmd_send").click(function(ev){
  ev.preventDefault();
  var cmd = $('#cmd_value').val();
  sendMessage({ 'data' : cmd});
  $('#cmd_value').val("");
});

$('#clear').click(function(){
  received.empty();
});


});

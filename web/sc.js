$(document).ready(function(){

var received = $('#received');

var ws_url = "ws://" + window.location.host + "/ws"; 
var socket = new WebSocket(ws_url);
 
socket.onopen = function(){  
  console.log("connected"); 
}; 

socket.onmessage = function (message) {
  var msg = message.data;
  console.log("receiving: " + msg);
  received.prepend(msg);
  received.prepend($('<br/>'));
};

socket.onclose = function(){
  console.log("disconnected"); 
};

var sendMessage = function(message) {
  console.log("sending:" + message.data);
  socket.send(message.data);
};


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

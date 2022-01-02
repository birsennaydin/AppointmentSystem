var app = require('express')();
var http = require('http').Server(app);
var io= require('socket.io')(http);

app.get('/', function (req,res){
    res.send('Anasayfa');
});

http.listen(3000, function () {
  console.log("server listening");
});

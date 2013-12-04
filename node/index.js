/*global server:true*/
var Express, Config;

Express  = require('express');
Config   = require('./config');

server   = new Express();

server.use(Express.static(__dirname.replace('node','angular')));
server.use(Express.static(__dirname.replace('node','angular_modules')));
server.use(Express.compress());
server.use(Express.urlencoded());
server.use(Express.json());
server.use(server.router);

server.get('/', function (request, response) {
    'use strict';
    response.sendfile(__dirname.replace('node','angular') + '/views/home/index.html');
});

server.listen(Config.host.port);
console.info('[SERVER] listening on port ' + Config.host.port);

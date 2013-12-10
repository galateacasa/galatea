var Express, server;

Express  = require('express');

if (!server) {
    server   = new Express();
    server.use(Express.static(__dirname.replace('node/modules','angular')));
    server.use(Express.static(__dirname.replace('node/modules','angular_modules')));
    server.use(Express.compress());
    server.use(Express.urlencoded());
    server.use(Express.json());
    server.use(Express.multipart());
    server.use(server.router);
    server.get('/', function (request, response) {
        'use strict';
        response.sendfile(__dirname.replace('node/modules','angular') + '/views/home/index.html');
    });
}

module.exports = server;

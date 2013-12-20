var Express, server, cloudinary, config;

Express    = require('express');
cloudinary = require('cloudinary');
config     = require('../config');

cloudinary.config(config.cloudinary);

if (!server) {
    server   = new Express();
    server.use(Express.static(__dirname.replace('node/modules','angular')));
    server.use(Express.static(__dirname.replace('node/modules','angular_modules')));
    server.use(Express.compress());
    server.use(Express.urlencoded());
    server.use(Express.json());
    server.use(Express.cookieParser());
    server.use(server.router);
    server.get('/', function (request, response) {
        'use strict';
        response.sendfile(__dirname.replace('node/modules','angular') + '/views/home/index.html');
    });

    server.post('/images', require('connect-multiparty')(), function (request, response) {
        'use strict';

        cloudinary.uploader.upload(request.files.file.path, function(result) {
            response.send(200, result.url);
        });
    });
}

module.exports = server;

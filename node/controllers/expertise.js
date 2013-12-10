var mongoose, server, Expertise;

mongoose  = require('mongoose');
server    = require('../modules/server');
Expertise = mongoose.model('Expertise');

server.get('/expertises', function (request, response, next) {
    'use strict';

    Expertise.find(function (error, expertises) {
        if (error) { return next(error); }
        response.send(200, expertises);
    });
});

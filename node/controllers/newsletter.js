var mongoose, server, Newsletter;

mongoose = require('mongoose');
server   = require('../modules/server');
Newsletter = mongoose.model('Newsletter');

server.post('/newsletters', function (request, response) {
    'use strict';

    var newsletter;
    newsletter = new Newsletter({
        'email' : request.param('email')
    });

    newsletter.save(function (error) {
        if (error) { return response.send(400, error); }
        response.send(201, newsletter);
    });
});

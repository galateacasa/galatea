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

server.get('/newsletters/:newsletterId', function (request, response, next) {
    'use strict';

    Newsletter.findById(request.params.newsletterId, function (error, newsletter) {
        if (error) { return next(error); }
        response.send(201, newsletter);
    });
});

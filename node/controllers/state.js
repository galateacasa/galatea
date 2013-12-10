var mongoose, server, State;

mongoose = require('mongoose');
server   = require('../modules/server');
State    = mongoose.model('State');

server.get('/countries/:countryId/states', function (request, response, next) {
    'use strict';

    State.find({country : request.params.countryId}, function (error, states) {
        if (error) { return next(error); }
        response.send(200, states);
    });
});

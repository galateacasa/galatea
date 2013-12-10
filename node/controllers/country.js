var mongoose, server, Country;

mongoose = require('mongoose');
server   = require('../modules/server');
Country  = mongoose.model('Country');

server.get('/countries', function (request, response, next) {
    'use strict';

    Country.find(function (error, countries) {
        if (error) { return next(error); }
        response.send(200, countries);
    });
});

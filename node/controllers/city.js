var mongoose, server, City;

mongoose = require('mongoose');
server   = require('../modules/server');
City     = mongoose.model('City');

server.get('/countries/:countryId/states/:stateId/cities', function (request, response, next) {
    'use strict';

    City.find({state : request.params.stateId}, function (error, cities) {
        if (error) { return next(error); }
        response.send(200, cities);
    });
});

server.get('/countries/:countryId/states/:stateId/cities/:cityId', function (request, response, next) {
    'use strict';

    City.findById(request.params.cityId, function (error, city) {
        if (error) { return next(error); }
        response.send(200, city);
    });
});

var mongoose, server, Category;

mongoose = require('mongoose');
server   = require('../modules/server');
Category = mongoose.model('Category');

server.get('/categories', function (request, response, next) {
    'use strict';

    Category.find(function (error, categories) {
        if (error) { return next(error); }
        response.send(200, categories);
    });
});

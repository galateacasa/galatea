var mongoose, server, auth, Ambiance;

mongoose   = require('mongoose');
server     = require('../modules/server');
auth       = require('../modules/auth');
Ambiance   = mongoose.model('Ambiance');

server.post('/ambiances', auth.authenticate, function (request, response) {
    'use strict';

    var ambiance;

    ambiance = new Ambiance({
        'name' : request.param('name'),
        'slug' : request.param('name').toLowerCase().replace(/\s/g, '-'),
        'user' : request.userId,
        'category' : request.param('category'),
        'image' : request.param('image'),
        'products' : request.param('products')
    });

    ambiance.save(function (error) {
        if (error) { return response.send(400, error); }
        response.send(201, ambiance);
    });
});

server.get('/ambiances', function (request, response, next) {
    'use strict';

    var query;

    query = {
        status : 'active'
    };

    if (request.param('featured')) {
        query.featured = true;
    }

    if (request.param('category')) {
        query.category = request.param('category');
    }

    Ambiance.find(query).populate('user').populate('category').populate('products').exec(function (error, ambiances) {
        if (error) { return next(error); }
        response.send(200, ambiances);
    });
});

server.get('/ambiances/:ambianceId', function (request, response, next) {
    'use strict';

    Ambiance.findOne({slug : request.params.ambianceId}).populate('user').populate('category').populate('products').exec(function (error, ambiance) {
        if (error) { return next(error); }
        response.send(200, ambiance);
    });
});

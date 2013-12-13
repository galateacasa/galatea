var mongoose, server, cloudinary, auth, Ambiance;

mongoose   = require('mongoose');
server     = require('../modules/server');
cloudinary = require('cloudinary');
auth       = require('../modules/auth');
Ambiance   = mongoose.model('Ambiance');

server.post('/ambiances', auth.authenticate, function (request, response) {
    'use strict';

    var ambiance;

    ambiance = new Ambiance({
        'name' : request.param('name'),
        'user' : request.userId,
        'category' : request.param('category'),
        'image' : request.param('image'),
        'status' : request.param('status'),
        'products' : request.param('products')
    });

    ambiance.save(function (error) {
        if (error) { return response.send(400, error); }
        response.send(201, ambiance);
    });
});

server.get('/ambiances', function (request, response, next) {
    'use strict';

    Ambiance.find(function (error, ambiances) {
        if (error) { return next(error); }
        response.send(200, ambiances);
    });
});

server.get('/ambiances/:ambianceId', function (request, response, next) {
    'use strict';

    Ambiance.findById(request.params.ambianceId).populate('category').populate('products').exec(function (error, ambiance) {
        if (error) { return next(error); }
        response.send(200, ambiance);
    });
});

server.put('/ambiances/:ambianceId/images', auth.authenticate, require('connect-multiparty')(), function (request, response) {
    'use strict';

    Ambiance.findById(request.params.ambianceId, function (error, ambiance) {
        if (error) { return response.send(400, error); }
        if (!ambiance) { return response.send(404, new Error('ambiance not found')); }

        cloudinary.uploader.upload(request.files.file.path, function(result) {
            ambiance.image = result.url;
            ambiance.save(function (error) {
                if (error) { return response.send(400, error); }
                response.send(200, ambiance);
            });
        });
    });
});

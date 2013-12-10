var mongoose, server, cloudinary, auth, Product;

mongoose   = require('mongoose');
server     = require('../modules/server');
cloudinary = require('cloudinary');
auth       = require('../modules/auth');
Product    = mongoose.model('Product');

server.post('/products', auth.authenticate, function (request, response) {
    'use strict';

    var product;

    product = new Product({
        'name' : request.param('name'),
        'user' : request.userId,
        'categories' : request.param('categories'),
        'measures' : request.param('measures'),
        'materials' : request.param('materials')
    });

    product.save(function (error) {
        if (error) { return response.send(400, error); }
        response.send(201, product);
    });
});

server.get('/products', function (request, response, next) {
    'use strict';

    Product.find({'categories' : request.param('categoryId')}, function (error, ambiances) {
        if (error) { return next(error); }
        response.send(200, ambiances);
    });
});

server.get('/products/:productId', function (request, response, next) {
    'use strict';

    Product.findById(request.params.productId).populate('categories').exec(function (error, product) {
        if (error) { return next(error); }
        response.send(200, product);
    });
});

server.post('/products/:productId/images', auth.authenticate, function (request, response) {
    'use strict';

    Product.findById(request.params.productId, function (error, product) {
        if (error) { return response.send(400, error); }
        if (!product) { return response.send(404, new Error('product not found')); }

        cloudinary.uploader.upload(request.files.file.path, function(result) {
            product.images.push(result.url);
            product.save(function (error) {
                if (error) { return response.send(400, error); }
                response.send(200, product);
            });
        });
    });
});

var mongoose, server, cloudinary, auth, Category, Product;

mongoose   = require('mongoose');
server     = require('../modules/server');
cloudinary = require('cloudinary');
auth       = require('../modules/auth');
Category   = mongoose.model('Category');
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

    Category.find({parent : request.param('categoryId')}, function (error, categories) {
        if (error) { return next(error); }
        categories.push({_id : request.param('categoryId')});
        Product.find({'categories' : {'$in' : categories.map(function (category) {
            return category._id;
        })}}).populate('user').populate('categories').exec(function (error, ambiances) {
            if (error) { return next(error); }
            response.send(200, ambiances);
        });
    });
});

server.get('/products/:productId', function (request, response, next) {
    'use strict';

    Product.findById(request.params.productId).populate('user').populate('categories').exec(function (error, product) {
        if (error) { return next(error); }
        response.send(200, product);
    });
});

server.post('/products/:productId/images', auth.authenticate, require('connect-multiparty')(), function (request, response) {
    'use strict';

    Product.findById(request.params.productId, function (error, product) {
        if (error) { return response.send(400, error); }
        if (!product) { return response.send(404, new Error('product not found')); }

        cloudinary.uploader.upload(request.files.file.path, function(result) {
            console.log(result);
            product.images.push(result.url);
            product.save(function (error) {
                if (error) { return response.send(400, error); }
                response.send(200, product);
            });
        });
    });
});

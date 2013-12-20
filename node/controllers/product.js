var mongoose, server, auth, Category, Product;

mongoose   = require('mongoose');
server     = require('../modules/server');
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

    Category.findOne({slug : request.param('categoryId')}, function (error, parentCategory) {
        Category.find({parent : parentCategory._id}, function (error, categories) {
            if (error) { return next(error); }
            categories.push(parentCategory);
            Product.find({'status' : 'selling', 'categories' : {'$in' : categories.map(function (category) {
                return category._id;
            })}}).populate('user').populate('categories').exec(function (error, ambiances) {
                if (error) { return next(error); }
                response.send(200, ambiances);
            });
        });
    });
});

server.get('/products/:productId', function (request, response, next) {
    'use strict';

    Product.findOne({slug : request.params.productId}).populate('user').populate('categories').exec(function (error, product) {
        if (error) { return next(error); }
        response.send(200, product);
    });
});

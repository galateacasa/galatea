var mongoose, server, auth, Category, Product, Ambiance;

mongoose   = require('mongoose');
server     = require('../modules/server');
auth       = require('../modules/auth');
Category   = mongoose.model('Category');
Product    = mongoose.model('Product');
Ambiance   = mongoose.model('Ambiance');

server.post('/products', auth.authenticate, function (request, response) {
    'use strict';

    var product;

    product = new Product({
        'name' : request.param('name'),
        'user' : request.userId,
        'categories' : request.param('categories'),
        'measures' : request.param('measures'),
        'materials' : request.param('materials'),
        'images' : request.param('images')
    });

    product.save(function (error) {
        if (error) { return response.send(400, error); }
        response.send(201, product);
    });
});

server.get('/products', function (request, response, next) {
    'use strict';

    Category.findOne({slug : request.param('categoryId')}, function (error, parentCategory) {
        var query;

        if (error) { return next(error); }

        if (parentCategory) {
            query = {parent : parentCategory._id};
        } else {
            query = {slug : request.param('categoryId')};
        }

        Category.find(query, function (error, categories) {
            var query;

            if (error) { return next(error); }

            query = {};

            if (request.param('name')) {
                query.name = new RegExp(request.param('name', ''), 'i');
            }
            if (request.param('categoryId')) {
                categories.push(parentCategory);
                query.categories = {'$in' : categories.map(function (category) {
                    return category._id;
                })};
            }
            if (request.param('voting')) {
                query.status = 'voting';
            } else {
                query.status = 'selling';
            }
            Product.find(query).populate('user').populate('categories').exec(function (error, products) {
                if (error) { return next(error); }
                response.send(200, products);
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

server.get('/products/:productId/similars', function (request, response, next) {
    'use strict';

    Product.findOne({slug : request.params.productId}).exec(function (error, product) {
        if (error) { return next(error); }

        Product.find({'categories' : {'$in' : product.categories}}).populate('user').populate('categories').exec(function (error, products) {
            if (error) { return next(error); }
            response.send(200, products);
        });
    });
});

server.get('/products/:productId/used-ambiances', function (request, response, next) {
    'use strict';

    Product.findOne({slug : request.params.productId}).exec(function (error, product) {
        if (error) { return next(error); }

        Ambiance.find({'products' : product._id}).populate('user').populate('category').populate('products').exec(function (error, ambiances) {
            if (error) { return next(error); }
            response.send(200, ambiances);
        });
    });
});

server.get('/products/:productId/similar-styles', function (request, response, next) {
    'use strict';

    Product.findOne({slug : request.params.productId}).exec(function (error, product) {
        if (error) { return next(error); }

        Ambiance.find({'products' : product._id}).populate('user').populate('category').populate('products').exec(function (error, ambiances) {
            if (error) { return next(error); }
            response.send(200, ambiances.reduce(function (products, ambiance) {
                return products.concat(ambiance.products);
            }, []));
        });
    });
});

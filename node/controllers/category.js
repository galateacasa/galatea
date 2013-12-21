var mongoose, server, Category;

mongoose = require('mongoose');
server   = require('../modules/server');
Category = mongoose.model('Category');

server.get('/categories', function (request, response, next) {
    'use strict';

    Category.find({parent : {$exists : false}}, function (error, categories) {
        if (error) { return next(error); }
        response.send(200, categories);
    });
});

server.get('/categories/:categoryId', function (request, response, next) {
    'use strict';

    Category.findOne({slug : request.params.categoryId}, function (error, category) {
        if (error) { return next(error); }
        Category.find({parent : category._id}, function (error, categories) {
            if (error) { return next(error); }

            response.send(200, {name : category.name, slug : category.slug, _id : category._id, image : category.image, subcategories : categories});
        });
    });
});

server.get('/subcategories', function (request, response, next) {
    'use strict';

    Category.find({parent : {$exists : true}}, function (error, categories) {
        if (error) { return next(error); }
        response.send(200, categories);
    });
});

server.get('/subcategories/:subcategoriesId', function (request, response, next) {
    'use strict';

    Category.findOne({slug : request.params.subcategoriesId}, function (error, category) {
        if (error) { return next(error); }
        response.send(200, category);
    });
});

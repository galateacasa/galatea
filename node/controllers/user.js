var mongoose, server, auth, crypto, User, Product, Ambiance;

mongoose   = require('mongoose');
server     = require('../modules/server');
auth       = require('../modules/auth');
crypto     = require('crypto');
User       = mongoose.model('User');
Product    = mongoose.model('Product');
Ambiance   = mongoose.model('Ambiance');

server.post('/users', function (request, response) {
    'use strict';

    var user;

    user = new User({
        'name' : request.param('name'),
        'surname' : request.param('surname'),
        'cpf' : request.param('cpf'),
        'email' : request.param('email'),
        'password' : crypto.createHash('md5').update(request.param('password')).digest('hex'),
        'photo' : request.param('photo'),
        'type' : request.param('type'),
        'company' : request.param('company'),
        'addresses' : request.param('addresses'),
        'about' : request.param('about')
    });
    user.save(function (error) {
        if (error) { return response.send(400, error); }
        response.send(201, user);
    });
});

server.put('/users/:userId/email-confirmation', auth.authenticate, function (request, response, next) {
    'use strict';

    User.findById(request.params.userId, function (error, user) {
        if (error) { return response.send(400, error); }
        if (!user) { return response.send(404, new Error('user not found')); }

        user.validated = true;
        user.save(function (error) {
            if (error) { return next(error); }
            response.send(200, user);
        });
    });
});

server.get('/users/me', auth.authenticate, function (request, response) {
    'use strict';

    User.findById(request.userId).exec(function (error, user) {
        if (error) { return response.send(400, error); }
        if (!user) { return response.send(404, new Error('user not found')); }
        response.send(200, user);
    });
});

server.get('/users/:userId', function (request, response) {
    'use strict';

    User.findById(request.params.userId).exec(function (error, user) {
        if (error) { return response.send(400, error); }
        if (!user) { return response.send(404, new Error('user not found')); }
        response.send(200, user);
    });
});

server.get('/users/:userId/favorite-ambiances', auth.authenticate, function (request, response) {
    'use strict';

    Ambiance.find({votes : request.params.userId === 'me' ? request.userId : request.params.userId}).populate('user').populate('category').populate('products').exec(function (error, ambiances) {
        if (error) { return response.send(400, error); }
        response.send(200, ambiances);
    });
});

server.get('/users/:userId/favorite-products', auth.authenticate, function (request, response) {
    'use strict';

    Product.find({votes : request.params.userId === 'me' ? request.userId : request.params.userId, status : 'selling'}).populate('user').populate('categories').exec(function (error, products) {
        if (error) { return response.send(400, error); }
        response.send(200, products);
    });
});

server.get('/users/:userId/favorite-projects', auth.authenticate, function (request, response) {
    'use strict';

    Product.find({votes : request.params.userId === 'me' ? request.userId : request.params.userId, status : 'voting'}).populate('user').populate('categories').exec(function (error, products) {
        if (error) { return response.send(400, error); }
        response.send(200, products);
    });
});

server.put('/users/:userId', auth.authenticate, function (request, response) {
    'use strict';

    User.findById(request.params.userId === 'me' ? request.userId : request.params.userId).exec(function (error, user) {
        if (error) { return response.send(400, error); }
        if (!user) { return response.send(404, new Error('user not found')); }

        user.name = request.param('name');
        user.surname = request.param('surname');
        user.cpf = request.param('cpf');
        user.photo = request.param('photo');
        user.type = request.param('type');
        user.company = request.param('company');
        user.addresses = request.param('addresses');
        user.about = request.param('about');

        user.save(function (error) {
            if (error) { return response.send(400, error); }
            response.send(200, user);
        });
    });
});

server.post('/users/me/login', function (request, response) {
    'use strict';

    User.findOne({email : request.param('email'), password : crypto.createHash('md5').update(request.param('password')).digest('hex')}, function (error, user) {
        if (error) { return response.send(400, error); }
        if (!user) { return response.send(401, new Error('invalid username or password')); }

        auth.login(user._id, function (error, token) {
            if (error) { return response.send(400, error); }
            response.cookie('XSRF-TOKEN', token);
            response.send(201, user);
        });
    });
});
var mongoose, server, cloudinary, auth, User;

mongoose   = require('mongoose');
server     = require('../modules/server');
cloudinary = require('cloudinary');
auth       = require('../modules/auth');
User       = mongoose.model('User');

server.post('/users', function (request, response) {
    'use strict';

    var user;

    user = new User({
        'email' : request.param('email'),
        'name' : request.param('name'),
        'surname' : request.param('surname'),
        'password' : request.param('password'),
        'type' : request.param('type'),
        'addresses' : request.param('addresses'),
        'company' : request.param('company'),
        'phone' : request.param('phone')
    });
    user.save(function (error) {
        if (error) { return response.send(400, error); }
        response.send(201, user);
    });
});

server.put('/users/:userId/photo', require('connect-multiparty'), function (request, response) {
    'use strict';

    User.findById(request.params.userId, function (error, user) {
        if (error) { return response.send(400, error); }
        if (!user) { return response.send(404, new Error('user not found')); }

        cloudinary.uploader.upload(request.files.file.path, function(result) {
            user.photo = result.url;
            user.save(function (error) {
                if (error) { return response.send(400, error); }
                response.send(200, user);
            });
        });
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

server.get('/users/:userId', auth.authenticate, function (request, response) {
    'use strict';

    User.findById(request.params.userId === 'me' ? request.userId : request.params.userId, function (error, user) {
        if (error) { return response.send(400, error); }
        if (!user) { return response.send(404, new Error('user not found')); }
        response.send(200, user);
    });
});

server.post('/sessions', function (request, response) {
    'use strict';

    User.findOne({email : request.param('email'), password : request.param('password')}, function (error, user) {
        if (error) { return response.send(400, error); }
        if (!user) { return response.send(401, new Error('invalid username or password')); }

        auth.login(user._id, function (error, token) {
            if (error) { return response.send(400, error); }
            response.cookie('XSRF-TOKEN', token);
            response.send(201, user);
        });
    });
});

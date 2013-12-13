var mongoose, server, auth, User, Order;

mongoose   = require('mongoose');
server     = require('../modules/server');
auth       = require('../modules/auth');
User       = mongoose.model('User');
Order      = mongoose.model('Order');

server.post('/users/:userId/add-to-cart', auth.authenticate, function (request, response, next) {
    'use strict';

    User.findById(request.params.userId, function (error, user) {
        if (error) { return next(error); }
        if (!user) { return response.send(404, new Error('user not found')); }

        user.cart.push({
            'product' : request.param('product'),
            'material' : request.param('material'),
            'measure' : request.param('measure'),
            'quantity' : request.param('quantity')
        });
        user.save(function (error) {
            if (error) { return response.send(400, error); }
            response.send(201, user);
        });
    });
});

server.post('/users/:userId/orders', auth.authenticate, function (request, response) {
    'use strict';

    var order;

    order = new Order({
        'user' : request.params.userId,
        'items' : request.param('items'),
        'deliveryDate' : request.param('measures')
    });

    order.save(function (error) {
        if (error) { return response.send(400, error); }
        response.send(201, order);
    });
});

server.get('/users/:userId/orders', auth.authenticate, function (request, response, next) {
    'use strict';

    Order.find({user : request.params.userId}).populate('items.product').exec(function (error, orders) {
        if (error) { return next(error); }
        response.send(200, orders);
    });
});

server.get('/users/:userId/orders/:orderId', auth.authenticate, function (request, response, next) {
    'use strict';

    Order.findById(request.params.orderId).populate('items.product').exec(function (error, order) {
        if (error) { return next(error); }
        if (!order) { return response.send(404, new Error('order not found')); }
        response.send(200, order);
    });
});

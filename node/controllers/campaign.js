var mongoose, server, auth, Campaign;

mongoose   = require('mongoose');
server     = require('../modules/server');
auth       = require('../modules/auth');
Campaign   = mongoose.model('Campaign');

server.post('/campaigns', function (request, response) {
    'use strict';

    var campaign;

    campaign = new Campaign({
        'name' : request.param('name'),
        'email' : request.param('email'),
        'message' :  request.param('message')
    });

    campaign.save(function (error) {
        if (error) { return response.send(400, error); }
        response.send(201, campaign);
    });
});

server.get('/campaigns', function (request, response, next) {
    'use strict';

    Campaign.find(function (error, campaigns) {
        if (error) { return next(error); }
        response.send(200, campaigns);
    });
});

server.get('/campaigns/:campaignId', function (request, response, next) {
    'use strict';

    Campaign.findById(request.params.campaignId, function (error, campaign) {
        if (error) { return next(error); }
        response.send(200, campaign);
    });
});
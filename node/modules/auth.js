var config, redis, crypto,
    secondsInOneHour;

config = require('../config');
redis  = require('./redis');
crypto = require('crypto');
secondsInOneHour = 3600;

exports.login = function (id, cb) {
    'use strict';

    var timestamp, token;

    timestamp = new Date().getTime();
    token = crypto.createHash('sha1').update(id + timestamp + config.host.salt).digest('hex');

    redis.set('token:' + token, id, function (error) {
        if (error) { return cb(error); }
        redis.expire(token, secondsInOneHour);
        cb(null, token);
    });
};

exports.authenticate = function (request, response, next) {
    'use strict';

    redis.get('token:' + (request.headers['x-xsrf-token'] || '').replace(/\"/g, ''), function (error, id) {
        if (error) { return next(error); }
        if (id === null) {
            response.send(401, {'error' : 'invalid token'});
        } else {
            request.userId = id;
            next();
        }
    });
};

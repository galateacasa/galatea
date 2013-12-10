var config, url, redis, client,
    uri;

config = require('../config');
url = require('url');
redis = require('redis');

if (!client) {
    if (config.redis.url) {
        uri = url.parse(config.authRedis.url) || null;
        client = redis.createClient(uri.port, uri.hostname);

        if (uri.auth) {
            client.auth(uri.auth.split(':')[1]);
        }
    } else {
        client = redis.createClient();
    }
}

module.exports = client;

var server, mongoose, config, fs;

config     = require('./config');
mongoose   = require('mongoose');
server     = require('./modules/server');
fs         = require('fs');

fs.readdir(__dirname + '/models', function (error, files) {
    'use strict';

    var i;

    for (i = 0; i < files.length; i += 1) {
        require(__dirname + '/models/' + files[i]);
    }
    mongoose.connect(config.mongo.uri, function () {
        console.info('[MONGO] connected to ' + config.mongo.uri);
    });
});

fs.readdir(__dirname + '/controllers', function (error, files) {
    'use strict';

    var i;

    for (i = 0; i < files.length; i += 1) {
        require(__dirname + '/controllers/' + files[i]);
    }
    require('ng-resource')(server, {
        paramDefaults : {
            user : {'userId' : '@_id'},
            order : {'userId' : '@user'},
            ambiance : {'ambianceId' : '@_id'},
            product : {'productId' : '@slug'},
            category : {'categoryId' : '@_id'},
            country : {'countryId' : '@_id'},
            state : {'countryId' : '@country', 'stateId' : '@_id'},
            city : {'countryId' : '@country', 'stateId' : '@state', 'cityId' : '@_id'},
            expertise : {'expertiseId' : '@_id'}
        },
        actions : {
            'user' : {'update' : {'method' : 'PUT'}},
            'product' : {}
        }
    });
    server.listen(config.host.port, function () {
        console.info('[SERVER] listening on port ' + config.host.port);
    });
});

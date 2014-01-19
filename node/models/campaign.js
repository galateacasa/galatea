var mongoose, server, schema, objectId;

mongoose = require('mongoose');
objectId = mongoose.Schema.Types.ObjectId;
server   = require('../modules/server');

schema = new mongoose.Schema({
    'name' : {
        'type' : String
    },
    'email' : {
        'type' : String
    },
    'message' : {
        'type' : String
    }
},{
    'collection' : 'campaigns'
});

schema.plugin(require('mongoose-json-select'), {
    '_id' : 1,
    'name' : 1,
    'email' : 1,
    'message' : 1
});

mongoose.model('Campaign', schema);

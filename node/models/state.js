var mongoose, server, schema, objectId;

mongoose = require('mongoose');
objectId = mongoose.Schema.Types.ObjectId;
server   = require('../modules/server');

schema = new mongoose.Schema({
    'name' : {
        'type' : String,
        'required' : true
    },
    'country' : {
        'type' : objectId,
        'ref' : 'Country'
    }
},{
    'collection' : 'states'
});

schema.plugin(require('mongoose-json-select'), {
    '_id' : 1,
    'name' : 1
});

mongoose.model('State', schema);

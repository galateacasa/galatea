var mongoose, server, schema, objectId;

mongoose = require('mongoose');
objectId = mongoose.Schema.Types.ObjectId;
server   = require('../modules/server');

schema = new mongoose.Schema({
    'name' : {
        'type' : String,
        'required' : true
    },
    'state' : {
        'type' : objectId,
        'ref' : 'State'
    }
},{
    'collection' : 'cities'
});

schema.plugin(require('mongoose-json-select'), {
    '_id' : 1,
    'name' : 1
});

mongoose.model('City', schema);

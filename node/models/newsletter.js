var mongoose, server, schema;

mongoose = require('mongoose');
server   = require('../modules/server');

schema = new mongoose.Schema({
    'email' : {
        'type' : String,
        'required' : true
    }
},{
    'collection' : 'newsletters'
});

schema.plugin(require('mongoose-json-select'), {
    '_id' : 1,
    'email' : 1
});

mongoose.model('Newsletter', schema);

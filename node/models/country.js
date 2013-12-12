var mongoose, server, schema;

mongoose = require('mongoose');
server   = require('../modules/server');

schema = new mongoose.Schema({
    'name' : {
        'type' : String,
        'required' : true
    }
},{
    'collection' : 'contries'
});

schema.plugin(require('mongoose-json-select'), {
    '_id' : 1,
    'name' : 1
});

mongoose.model('Country', schema);

var mongoose, server, schema, objectId;

mongoose = require('mongoose');
objectId = mongoose.Schema.Types.ObjectId;
server   = require('../modules/server');

schema = new mongoose.Schema({
    'name' : {
        'type' : String,
        'required' : true
    },
    'slug' : {
        'type' : String,
        'required' : true
    },
    'parent' : {
        'type' : objectId
    },
    'image' : {
        'type' : String
    }
},{
    'collection' : 'categories'
});

schema.plugin(require('mongoose-json-select'), {
    '_id' : 1,
    'name' : 1,
    'slug' : 1,
    'image' : 1
});

mongoose.model('Category', schema);

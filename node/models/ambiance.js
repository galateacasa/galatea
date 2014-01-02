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
        'type' : String
    },
    'user' : {
        'type' : objectId,
        'ref' : 'User',
        'required' : true
    },
    'category' : {
        'type' : objectId,
        'ref' : 'Category',
        'required' : true
    },
    'image' : {
        'type' : String
    },
    'date' : {
        'type' : Date,
        'default' : Date.now
    },
    'featured' : {
        'type' : Boolean
    },
    'status' : {
        'type' : String,
        'enum' : ['active', 'inactive'],
        'default' : 'active'
    },
    'votes' : [{
        'type' : objectId,
        'ref' : 'User',
        'required' : true
    }],
    'products' : [{
        'type' : objectId,
        'ref' : 'Product',
        'required' : true
    }]
},{
    'collection' : 'ambiances'
});

schema.plugin(require('mongoose-json-select'), {
    '_id' : 1,
    'name' : 1,
    'slug' : 1,
    'user' : 1,
    'category' : 1,
    'image' : 1,
    'date' : 1,
    'status' : 1,
    'votes' : 1,
    'products' : 1
});

mongoose.model('Ambiance', schema);

var mongoose, server, schema, objectId;

mongoose = require('mongoose');
objectId = mongoose.Schema.Types.ObjectId;
server   = require('../modules/server');

schema = new mongoose.Schema({
    'name' : {
        'type' : String,
        'required' : true
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
    'status' : {
        'type' : String,
        'enum' : ['pending', 'voting', 'selling'],
        'default' : 'pending'
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
    'user' : 1,
    'category' : 1,
    'image' : 1,
    'status' : 1,
    'votes' : 1,
    'products' : 1
});

mongoose.model('Ambiance', schema);

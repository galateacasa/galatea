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
    'categories' : [{
        'type' : objectId,
        'ref' : 'Category'
    }],
    'images' : [{
        'type' : String
    }],
    'status' : {
        'type' : String,
        'enum' : ['pending', 'voting', 'selling'],
        'default' : 'pending'
    },
    'measures' : [{
        'width' : {
            'type' : Number
        },
        'height' : {
            'type' : Number
        },
        'depth' : {
            'type' : Number
        }
    }],
    'materials' : [{
        'material' : {
            'type' : String
        }
    }],
    'votes' : [{
        'type' : objectId,
        'ref' : 'User',
        'required' : true
    }]
},{
    'collection' : 'products',
    'toJSON' : {'virtuals' : true},
    'toObject' : {'virtuals' : true}
});

schema.virtual('productId').get(function () {
    'use strict';

    return this._id;
});

schema.plugin(require('mongoose-json-select'), {
    '_id' : 0,
    'productId' : 1,
    'name' : 1,
    'description' : 1,
    'user' : 1,
    'categories' : 1,
    'images' : 1,
    'status' : 1,
    'price' : 1,
    'measures' : 1,
    'material' : 1,
    'votes' : 1
});

mongoose.model('Product', schema);

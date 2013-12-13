var mongoose, server, schema, objectId;

mongoose = require('mongoose');
objectId = mongoose.Schema.Types.ObjectId;
server   = require('../modules/server');

schema = new mongoose.Schema({
    'user' : {
        'type' : objectId,
        'ref' : 'User',
        'required' : true
    },
    'items' : [{
        'product' : {
            'type' : objectId,
            'ref' : 'Category',
            'required' : true
        },
        'material' : {
            'type' : objectId,
            'required' : true
        },
        'measure' : {
            'type' : objectId,
            'required' : true
        },
        'quantity' : {
            'type' : Number,
            'required' : true
        }
    }],
    'deliveryDate' : {
        'type' : Date
    },
    'status' : {
        'type' : String,
        'enum' : ['pending', 'payed']
    }
},{
    'collection' : 'orders'
});

schema.plugin(require('mongoose-json-select'), {
    '_id' : 1,
    'user' : 1,
    'items' : 1,
    'deliveryDate' : 1,
    'status' : 1
});

mongoose.model('Order', schema);

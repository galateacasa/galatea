var mongoose, server, schema;

mongoose = require('mongoose');
server   = require('../modules/server');

schema = new mongoose.Schema({
    'name' : {
        'type' : String,
        'required' : true
    },
    'email' : {
        'type' : String,
        'required' : true
    },
    'areaCode' : {
        'type' : String
    },
    'phone' : {
        'type' : String
    },
    'subject' : {
        'type' : String
    },
    'order' : {
        'type' : String
    },
    'message' : {
        'type' : String
    }
},{
    'collection' : 'contacts',
    'toJSON' : {'virtuals' : true},
    'toObject' : {'virtuals' : true}
});

schema.virtual('contactId').get(function () {
    'use strict';

    return this._id;
});

schema.plugin(require('mongoose-json-select'), {
    '_id' : 0,
    'contactId' : 1,
    'name' : 1,
    'email' : 1,
    'areaCode' : 1,
    'phone' : 1,
    'subject' : 1,
    'order' : 1,
    'message' : 1
});

mongoose.model('Contact', schema);

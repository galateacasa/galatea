var mongoose, server, schema;

mongoose = require('mongoose');
server   = require('../modules/server');

schema = new mongoose.Schema({
    'email' : {
        'type' : String,
        'required' : true
    }
},{
    'collection' : 'newsletters',
    'toJSON' : {'virtuals' : true},
    'toObject' : {'virtuals' : true}
});

schema.virtual('newsletterId').get(function () {
    'use strict';

    return this._id;
});

schema.plugin(require('mongoose-json-select'), {
    '_id' : 0,
    'newsletterId' : 1,
    'email' : 1
});

mongoose.model('Newsletter', schema);

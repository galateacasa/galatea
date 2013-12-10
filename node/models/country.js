var mongoose, server, schema;

mongoose = require('mongoose');
server   = require('../modules/server');

schema = new mongoose.Schema({
    'name' : {
        'type' : String,
        'required' : true
    }
},{
    'collection' : 'contries',
    'toJSON' : {'virtuals' : true},
    'toObject' : {'virtuals' : true}
});

schema.virtual('countryId').get(function () {
    'use strict';

    return this._id;
});

schema.plugin(require('mongoose-json-select'), {
    '_id' : 0,
    'countryId' : 1,
    'name' : 1
});

mongoose.model('Country', schema);

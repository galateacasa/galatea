var mongoose, server, schema;

mongoose = require('mongoose');
server   = require('../modules/server');

schema = new mongoose.Schema({
    'name' : {
        'type' : String,
        'required' : true
    },
    'subcategories' : [{
        'name' : {
            'type' : String,
            'required' : true
        }
    }]
},{
    'collection' : 'categories',
    'toJSON' : {'virtuals' : true},
    'toObject' : {'virtuals' : true}
});

schema.virtual('categoryId').get(function () {
    'use strict';

    return this._id;
});

schema.plugin(require('mongoose-json-select'), {
    '_id' : 0,
    'categoryId' : 1,
    'name' : 1,
    'subcategories' : 1
});

mongoose.model('Category', schema);

var mongoose, server, schema;

mongoose = require('mongoose');
server   = require('../modules/server');

schema = new mongoose.Schema({
    'name' : {
        'type' : String,
        'required' : true
    }
},{
    'collection' : 'expertises',
    'toJSON' : {'virtuals' : true},
    'toObject' : {'virtuals' : true}
});

schema.virtual('expertiseId').get(function () {
    'use strict';

    return this._id;
});

schema.plugin(require('mongoose-json-select'), {
    '_id' : 0,
    'expertiseId' : 1,
    'name' : 1
});

mongoose.model('Expertise', schema);

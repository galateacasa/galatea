var mongoose, server, schema, objectId;

mongoose = require('mongoose');
objectId = mongoose.Schema.Types.ObjectId;
server   = require('../modules/server');

schema = new mongoose.Schema({
    'name' : {
        'type' : String,
        'required' : true
    },
    'country' : {
        'type' : objectId,
        'ref' : 'Country'
    }
},{
    'collection' : 'states',
    'toJSON' : {'virtuals' : true},
    'toObject' : {'virtuals' : true}
});

schema.virtual('stateId').get(function () {
    'use strict';

    return this._id;
});

schema.plugin(require('mongoose-json-select'), {
    '_id' : 0,
    'stateId' : 1,
    'name' : 1
});

mongoose.model('State', schema);

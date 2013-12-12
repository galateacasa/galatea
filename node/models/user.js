var mongoose, server, schema, objectId, email;

mongoose = require('mongoose');
objectId = mongoose.Schema.Types.ObjectId;
server   = require('../modules/server');
email    = require('../modules/emails');

schema = new mongoose.Schema({
    'email' : {
        'type' : String,
        'required' : true,
        'unique' : true
    },
    'name' : {
        'type' : String,
        'required' : true
    },
    'surname' : {
        'type' : String,
        'required' : true
    },
    'password' : {
        'type' : String,
        'required' : true
    },
    'photo' : {
        'type' : String
    },
    'validated' : {
        'type' : Boolean,
        'default' : false
    },
    'type' : {
        'type' : String,
        'required' : true,
        'enum' : ['decorator', 'supplier', 'client', 'designer']
    },
    'company' : {
        'name' : {
            'type' : String
        },
        'cnpj' : {
            'type' : String
        },
        'expertise' : {
            'type' : objectId,
            'ref' : 'Expertise'
        }
    },
    'address' : {
        'zipcode' : {
            'type' : String
        },
        'street' : {
            'type' : String
        },
        'number' : {
            'type' : String
        },
        'complement' : {
            'type' : String
        },
        'country' : {
            'type' : objectId,
            'ref' : 'Country'
        },
        'state' : {
            'type' : objectId,
            'ref' : 'State'
        },
        'city' : {
            'type' : objectId,
            'ref' : 'City'
        }
    },
    'phone' : {
        'areaCode' : {
            'type' : Number
        },
        'number' : {
            'type' : String
        }
    }
},{
    'collection' : 'users'
});

schema.pre('save', function (next) {
    'use strict';

    if (!this.isNew) { return next(); }
    email.confirmation(this, next);
});

schema.plugin(require('mongoose-json-select'), {
    '_id' : 1,
    'name' : 1,
    'surname' : 1,
    'email' : 1,
    'password' : 0,
    'photo' : 1,
    'type' : 1,
    'company' : 1,
    'address' : 1,
    'phone' : 1
});

mongoose.model('User', schema);

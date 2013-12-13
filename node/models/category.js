var mongoose, server, schema;

mongoose = require('mongoose');
server   = require('../modules/server');

schema = new mongoose.Schema({
    'name' : {
        'type' : String,
        'required' : true
    },
    'slug' : {
        'type' : String,
        'required' : true
    },
    'subcategories' : [{
        'name' : {
            'type' : String,
            'required' : true
        },
        'slug' : {
            'type' : String,
            'required' : true
        }
    }]
},{
    'collection' : 'categories'
});

schema.plugin(require('mongoose-json-select'), {
    '_id' : 1,
    'name' : 1,
    'subcategories' : 1
});

mongoose.model('Category', schema);

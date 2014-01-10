var mongoose, config, schema, itemSchema, objectId, Pagseguro;

mongoose  = require('mongoose');
objectId  = mongoose.Schema.Types.ObjectId;
config    = require('../config');
Pagseguro = require('pagseguro');

schema = new mongoose.Schema({
    'user' : {
        'type' : objectId,
        'ref' : 'User',
        'required' : true
    },
    'items' : [itemSchema = new mongoose.Schema({
        'product' : {
            'type' : objectId,
            'ref' : 'Product',
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
    })],
    'deliveryDate' : {
        'type' : Date
    },
    'status' : {
        'type' : String,
        'enum' : ['pending', 'payed'],
        'default' : 'pending'
    },
    'code' : {
        'type' : String
    }
},{
    'collection' : 'orders'
});

schema.methods.pagseguro = function (callback) {
    'use strict';

    var self;

    self = this;
    mongoose.model('Order').findById(this._id).populate('user').populate('items.product').exec(function (error, order) {
        var pagseguro;

        if (error) { return callback(error); }

        pagseguro = new Pagseguro(config.pagseguro.email, config.pagseguro.key);
        pagseguro.currency('BRL');
        pagseguro.reference(this._id);

        order.items.forEach(function (item) {
            var price;

            price  = item.product.price;
            price += item.product.measures.filter(function (measure) {
                return measure._id.toString() === item.measure.toString();
            }).pop().priceIncrease;
            price += item.product.materials.filter(function (material) {
                return material._id.toString() === item.material.toString();
            }).pop().priceIncrease;
            price *= 1.07;

            pagseguro.addItem({
                'id' : item.product._id.toString(),
                'description' : item.product.name,
                'amount' : price.toFixed(2),
                'quantity' : item.quantity
            });
        });

        pagseguro.buyer({
            name: order.user.name + ' ' + order.user.surname,
            email: order.user.email,
            phoneAreaCode: order.user.phone ? order.user.phone.areaCode : undefined,
            phoneNumber: order.user.phone ? order.user.phone.number : undefined
        });

        pagseguro.send(function (error, response) {
            if (error) { return callback(error); }

            self.code = (/<code>([A-Z0-9]*)<\/code>/).exec(response)[1];
            self.save(callback);
        });
    });
};

schema.plugin(require('mongoose-json-select'), {
    '_id' : 1,
    'user' : 1,
    'items' : 1,
    'deliveryDate' : 1,
    'status' : 1,
    'code' : 1
});

mongoose.model('Order', schema);

var mongoose, server, Contact;

mongoose = require('mongoose');
server   = require('../modules/server');
Contact  = mongoose.model('Contact');

server.post('/contacts', function (request, response) {
    'use strict';

    var contact;
    contact = new Contact({
        'name' : request.param('name'),
        'email' : request.param('email'),
        'areaCode' : request.param('areaCode'),
        'phone' : request.param('phone'),
        'subject' : request.param('subject'),
        'order' : request.param('order'),
        'message' : request.param('message')
    });

    contact.save(function (error) {
        if (error) { return response.send(400, error); }
        response.send(201, contact);
    });
});

server.get('/contacts/:contactId', function (request, response, next) {
    'use strict';

    Contact.findById(request.params.contactId, function (error, contact) {
        if (error) { return next(error); }
        response.send(201, contact);
    });
});

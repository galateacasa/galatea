var config, auth, mandrill, welcomeTemplate;

config          = require('../../config');
auth            = require('../auth');
mandrill        = require('node-mandrill')('q1PbF9RgBFJqeszPweu7AA');

welcomeTemplate = new require('handlebars').compile(require('fs').readFileSync(__dirname + '/welcome.html').toString());

exports.confirmation = function (user, cb) {
    'use strict';

    auth.login(user._id, function (error, token) {
        if (error) { return cb(error); }
        mandrill('/messages/send', { message: {
            'to' : [{'email' : user.email, 'name': user.name}],
            'from_email' : 'contato@galateacasa.com.br',
            'subject' : 'Galatea - Confirme seu cadastro',
            'html' : welcomeTemplate({
                'host' : 'http://' + config.host.url + ':' + config.host.port,
                'name' : user.name,
                'confirmation_url' : 'http://' + config.host.url + ':' + config.host.port + '/#/confirmar-email?token=' + token + '&userId=' + user._id
            })
        }});
        cb();
    });
};

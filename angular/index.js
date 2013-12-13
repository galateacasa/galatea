/*global angular:false*/
angular.module('galatea', ['galatea.controllers.institutional', 'galatea.controllers.newsletter', 'galatea.controllers.user', 'galatea.controllers.ambiance', 'galatea.controllers.product', 'galatea.controllers.cart', 'resources', 'facebook']).config(function ($facebookProvider) {
    'use strict';

    $facebookProvider.init({
        appId : '333099176831507',
        channelUrl : '//localhost:3000',
        status : true,
        cookie : true,
        xfbml : true
    });
}).run(function ($rootScope, user, category) {
    'use strict';

    $rootScope.categories = category.query();
    $rootScope.user = user.get({'userId' : 'me'});
});

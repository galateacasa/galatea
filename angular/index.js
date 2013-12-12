/*global angular:false*/
angular.module('galatea', ['ngCookies', 'galatea.controllers.institutional', 'galatea.controllers.newsletter', 'galatea.controllers.user', 'galatea.controllers.ambiance', 'galatea.controllers.product', 'resources', 'facebook']).config(function ($facebookProvider) {
    'use strict';

    $facebookProvider.init({
        appId : '333099176831507',
        channelUrl : '//localhost:3000',
        status : true,
        cookie : true,
        xfbml : true
    });
}).run(function ($rootScope, $cookieStore, $location, user, category) {
    'use strict';

    if ($location.search().token) {
        $cookieStore.put('XSRF-TOKEN', $location.search().token);
    }
    $rootScope.categories = category.query();
    $rootScope.user = user.get({'userId' : 'me'});
});

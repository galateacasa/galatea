(function () {
    "use strict";

    function defineString(extended, is, array, args) {

        var isUndefinedOrNull = is.isUndefinedOrNull,
            CAMELIZE_CONVERT_REGEXP = /_(.)/g,
            DASH = '-',
            UNDERSCORE = '_',
            UNDERSCORE_CONVERT_REGEXP1 = /([A-Z]+)(\d+|[A-Z][a-z])/g,
            UNDERSCORE_CONVERT_REGEXP2 = /(\d+|[a-z])(\d+|[A-Z])/g,
            UNDERSCORE_CONVERT_REPLACE = '$1_$2',
            PLURALS = [], SINGULARS = [], UNCOUNTABLES = [];

        function _plural(rule, replacement) {
            PLURALS.unshift([rule, replacement]);
        }

        function _singular(rule, replacement) {
            SINGULARS.unshift([rule, replacement]);
        }

        function _irregular(singular, plural) {
            _plural(new RegExp("(" + singular.substr(0, 1) + ")" + singular.substr(1) + "$"), "$1" + plural.substr(1));
            _singular(new RegExp("(" + plural.substr(0, 1) + ")" + plural.substr(1) + "$"), "$1" + singular.substr(1));
        }

        function _uncountable(words) {
            UNCOUNTABLES.push(args.argsToArray(arguments));
            UNCOUNTABLES = array.flatten(UNCOUNTABLES);
        }

        _plural(/$/, 's');
        _plural(/s$/i, 's');
        _plural(/(alias|(?:stat|octop|vir|b)us)$/i, '$1es');
        _plural(/(buffal|tomat)o$/i, '$1oes');
        _plural(/([ti])um$/i, '$1a');
        _plural(/sis$/i, 'ses');
        _plural(/(?:([^f])fe|([lr])f)$/i, '$1$2ves');
        _plural(/(hive)$/i, '$1s');
        _plural(/([^aeiouy]|qu)y$/i, '$1ies');
        _plural(/(x|ch|ss|sh)$/i, '$1es');
        _plural(/(matr|vert|ind)ix|ex$/i, '$1ices');
        _plural(/([m|l])ouse$/i, '$1ice');
        _plural(/^(ox)$/i, "$1en");

        _singular(/s$/i, '');
        _singular(/([ti])a$/i, '$1um');
        _singular(/(analy|ba|cri|diagno|parenthe|progno|synop|the)ses$/i, '$1sis');
        _singular(/([^f])ves$/i, '$1fe');
        _singular(/([h|t]ive)s$/i, '$1');
        _singular(/([lr])ves$/i, '$1f');
        _singular(/([^aeiouy]|qu)ies$/i, '$1y');
        _singular(/(m)ovies$/i, '$1ovie');
        _singular(/(x|ch|ss|sh)es$/i, '$1');
        _singular(/([m|l])ice$/i, '$1ouse');
        _singular(/buses$/i, 'bus');
        _singular(/oes$/i, 'o');
        _singular(/shoes$/i, 'shoe');
        _singular(/(alias|(?:stat|octop|vir|b)us)es$/i, '$1');
        _singular(/(vert|ind)ices$/i, '$1ex');
        _singular(/matrices$/i, 'matrix');

        _irregular('person', 'people');
        _irregular('man', 'men');
        _irregular('child', 'children');
        _irregular('sex', 'sexes');
        _irregular('move', 'moves');
        _irregular('quiz', 'quizzes');
        _irregular('testis', 'testes');

        _uncountable("equipment", "information", "rice", "money", "species", "series", "fish", "sheep", "news");


        /**
         * Converts a string to camelcase
         *
         * @example
         *  comb.camelize('hello_world') => helloWorld
         *  comb.camelize('column_name') => columnName
         *  comb.camelize('columnName') => columnName
         *  comb.camelize(null) => null
         *  comb.camelize() => undefined
         *
         * @param {String} str the string to camelize
         * @memberOf comb
         * @returns {String} the camelized version of the string
         */
        function camelize(str) {
            var ret = str;
            if (!isUndefinedOrNull(str)) {
                ret = str.replace(CAMELIZE_CONVERT_REGEXP, function (a, b) {
                    return b.toUpperCase();
                });
            }
            return ret;
        }

        function underscore(str) {
            var ret = str;
            if (!isUndefinedOrNull(str)) {
                ret = str.replace(UNDERSCORE_CONVERT_REGEXP1, UNDERSCORE_CONVERT_REPLACE)
                    .replace(UNDERSCORE_CONVERT_REGEXP2, UNDERSCORE_CONVERT_REPLACE)
                    .replace(DASH, UNDERSCORE).toLowerCase();
            }
            return ret;
        }

        function classify(str) {
            var ret = str;
            if (!isUndefinedOrNull(str)) {
                ret = camelize(singularize(str.replace(/.*\./g, '')));
            }
            return ret;
        }

        function pluralize(str) {
            var ret = str;
            if (!isUndefinedOrNull(str)) {
                if (array.indexOf(UNCOUNTABLES, str) === -1) {
                    for (var i in PLURALS) {
                        var s = PLURALS[i], rule = s[0], replacement = s[1];
                        if ((ret = ret.replace(rule, replacement)) !== str) {
                            break;
                        }
                    }
                }
            }
            return ret;
        }

        function singularize(str) {
            var ret = str, l = SINGULARS.length;
            if (!isUndefinedOrNull(str)) {
                if (array.indexOf(UNCOUNTABLES, str) === -1) {
                    for (var i = 0; i < l; i++) {
                        var s = SINGULARS[i], rule = s[0], replacement = s[1];
                        if ((ret = ret.replace(rule, replacement)) !== str) {
                            break;
                        }
                    }
                }
            }
            return ret;
        }

        var inflect = {
            singular: _singular,
            plural: _plural,
            uncountable: _uncountable,
            camelize: camelize,
            underscore: underscore,
            classify: classify,
            pluralize: pluralize,
            singularize: singularize
        };

        return extended.define(is.isString, inflect).expose(inflect);

    }

    if ("undefined" !== typeof exports) {
        if ("undefined" !== typeof module && module.exports) {
            module.exports = defineString(require("extended"), require("is-extended"), require("array-extended"), require("arguments-extended"));

        }
    } else if ("function" === typeof define && define.amd) {
        define(["extended", "is-extended", "array-extended", "arguments-extended"], function (extended, is, array, args) {
            return defineString(extended, is, array, args);
        });
    } else {
        this.inflectionExtended = defineString(this.extended, this.isExtended, this.arrayExtended, this.argumentsExtended);
    }

}).call(this);







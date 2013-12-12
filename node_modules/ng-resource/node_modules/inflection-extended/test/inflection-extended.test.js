"use strict";
var it = require('it'),
    assert = require('assert'),
    inflect = require("../");

it.describe("inflectionExtended", function (it) {
    var INFLECTIONS = {
        test: "tests",
        ax: "axes",
        testis: "testes",
        octopus: "octopuses",
        virus: "viruses",
        alias: "aliases",
        status: "statuses",
        bus: "buses",
        buffalo: "buffaloes",
        tomato: "tomatoes",
        datum: "data",
        bacterium: "bacteria",
        analysis: "analyses",
        basis: "bases",
        diagnosis: "diagnoses",
        parenthesis: "parentheses",
        prognosis: "prognoses",
        synopsis: "synopses",
        thesis: "theses",
        wife: "wives",
        giraffe: "giraffes",
        self: "selves",
        dwarf: "dwarves",
        hive: "hives",
        fly: "flies",
        buy: "buys",
        soliloquy: "soliloquies",
        day: "days",
        attorney: "attorneys",
        boy: "boys",
        hoax: "hoaxes",
        lunch: "lunches",
        princess: "princesses",
        matrix: "matrices",
        vertex: "vertices",
        index: "indices",
        mouse: "mice",
        louse: "lice",
        quiz: "quizzes",
        motive: "motives",
        movie: "movies",
        series: "series",
        crisis: "crises",
        person: "people",
        man: "men",
        woman: "women",
        child: "children",
        sex: "sexes",
        move: "moves"
    };
//Super of other classes

    it.describe(".camelize", function (it) {

        it.describe("as a monad", function (it) {

            it.should("camelize a string", function () {
                assert.equal(inflect("hello_world").camelize().value(), "helloWorld");
                assert.equal(inflect("column_name").camelize().value(), "columnName");
                assert.equal(inflect("columnName").camelize().value(), "columnName");
            });
        });
        it.describe("as a function", function (it) {
            it.should("camelize a string", function () {
                assert.isNull(inflect.camelize(null));
                assert.isUndefined(inflect.camelize());
                assert.equal(inflect.camelize("hello_world"), "helloWorld");
                assert.equal(inflect.camelize("column_name"), "columnName");
                assert.equal(inflect.camelize("columnName"), "columnName");
            });
        });
    });

    it.describe(".underscore", function (it) {

        it.describe("as a monad", function (it) {
            it.should("underscore a string", function () {
                assert.equal(inflect("helloWorld").underscore().value(), "hello_world");
                assert.equal(inflect("helloWorld1").underscore().value(), "hello_world_1");
                assert.equal(inflect("1HelloWorld").underscore().value(), "1_hello_world");
                assert.equal(inflect("column_name").underscore().value(), "column_name");
                assert.equal(inflect("columnName").underscore().value(), "column_name");
            });
        });
        it.describe("as a function", function (it) {
            it.should("underscore a string", function () {
                assert.isNull(inflect.underscore(null));
                assert.isUndefined(inflect.underscore());
                assert.equal(inflect.underscore("helloWorld"), "hello_world");
                assert.equal(inflect.underscore("helloWorld1"), "hello_world_1");
                assert.equal(inflect.underscore("1HelloWorld"), "1_hello_world");
                assert.equal(inflect.underscore("column_name"), "column_name");
                assert.equal(inflect.underscore("columnName"), "column_name");
            });

        });
    });

    it.describe(".classify", function (it) {

        it.describe("as a monad", function (it) {
            it.should("classify a string", function () {
                assert.equal(inflect('egg_and_hams').classify().value(), "eggAndHam");
                assert.equal(inflect('post').classify().value(), "post");
                assert.equal(inflect('schema.post').classify().value(), "post");
            });
        });
        it.describe("as a function", function (it) {
            it.should("classify a string", function () {
                assert.isNull(inflect.classify(null));
                assert.isUndefined(inflect.classify());
                assert.equal(inflect.classify('egg_and_hams'), "eggAndHam");
                assert.equal(inflect.classify('post'), "post");
                assert.equal(inflect.classify('schema.post'), "post");
            });

        });
    });

    it.describe(".singularize", function (it) {

        it.describe("as a monad", function (it) {
            it.should("singularize a string", function () {
                for (var i in INFLECTIONS) {
                    assert.equal(inflect(INFLECTIONS[i]).singularize().value(), i);
                }
            });
        });
        it.describe("as a function", function (it) {
            it.should("singularize a string", function () {
                assert.isNull(inflect.singularize(null));
                assert.isUndefined(inflect.singularize());
                for (var i in INFLECTIONS) {
                    assert.equal(inflect.singularize(INFLECTIONS[i]), i);
                }
            });
        });
    });

    it.describe(".pluralize", function (it) {

        it.describe("as a monad", function (it) {
            it.should("pluralize a string", function () {
                for (var i in INFLECTIONS) {
                    assert.equal(inflect(i).pluralize().value(), INFLECTIONS[i]);
                }
            });
        });
        it.describe("as a function", function (it) {
            it.should("pluralize a string", function () {
                assert.isNull(inflect.pluralize(null));
                assert.isUndefined(inflect.pluralize());
                for (var i in INFLECTIONS) {
                    assert.equal(inflect.pluralize(i), INFLECTIONS[i]);
                }
            });
        });
    });
});


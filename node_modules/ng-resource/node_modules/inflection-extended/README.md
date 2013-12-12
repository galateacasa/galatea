[![Build Status](https://travis-ci.org/doug-martin/inflection-extended.png?branch=master)](https://travis-ci.org/doug-martin/inflection-extended)

[![browser support](https://ci.testling.com/doug-martin/inflection-extended.png)](http://ci.testling.com/doug-martin/inflection-extended)

# inflection-extended

`inflection-extended` is a Javascript library that can contains different inflection functions.

`inflection-extended` can be used as a monad library that be be incorporated into [`extended`](https://github.com/doug-martin/extended) or used standalone.

```javascript
var inflect = require("inflection-extended");

inflect.camelize("hello_world");  //helloWorld
```

Or

```javascript
var myextended = require("extended")
	.register(require("inflection-extended"));

myExtended.camelize("hello_world");  //helloWorld
```

## Installation

```
npm install inflection-extended
```

Or [download the source](https://raw.github.com/doug-martin/inflection-extended/master/index.js) ([minified](https://raw.github.com/doug-martin/inflection-extended/master/inflection-extended.min.js))

## Usage

**`camelize`**

Converts a underscored string to camelcase

```javascript
//as a function
inflect.camelize("hello_world");  //helloWorld
inflect.camelize("column_name"); //columnName
inflect.camelize("columnName"); //columnName
inflect.camelize(null); //null
inflect.camelize(); //undefined

//as a monad
inflect("hello_world").camelize().value();  //helloWorld
inflect("column_name").camelize().value(); //columnName
inflect("columnName").camelize().value(); //columnName
```

**`underscore`**

Converts a camelcase string to the underscored string. 

```javascript
//as a function
inflect.underscore("helloWorld"); //hello_world
inflect.underscore("column_name"); //column_name
inflect.underscore("columnName"); //column_name
inflect.underscore(null); //null
inflect.underscore(); //undefined

//as a monad
inflect("helloWorld").underscore().value(); //hello_world
inflect("column_name").underscore().value(); //column_name
inflect("columnName").underscore().value(); //column_name
```

**`classify`**

Singularizes and camelizes a string.  Also strips out all characters preceding and including a period (".").

```javascript
//as a function
inflect.classify("egg_and_hams"); //eggAndHam
inflect.classify("post"); //post
inflect.classify("schema.post"); //post

//as a monad
inflect("egg_and_hams").classify().value(); //eggAndHam
inflect("post").classify().value(); //post
inflect("schema.post").classify().value(); //post
```  

**`singularize`**

The reverse of pluralize, returns the singular form of a word.

```javascript
//as a function
inflect.singularize("posts"); //post
inflect.singularize("octopi"); //octopus
inflect.singularize("sheep"); //sheep
inflect.singularize("word"); //word
inflect.singularize("the blue mailmen"); //the blue mailman
inflect.singularize("CamelOctopi"); //CamelOctopus

//as a monad
inflect("posts").singularize().value(); //post
inflect("octopi").singularize().value(); //octopus
inflect("sheep").singularize().value(); //sheep
inflect("word").singularize().value(); //word
inflect("the blue mailmen").singularize().value(); //the blue mailman
inflect("CamelOctopi").singularize().value(); //CamelOctopus
``` 

**`pluralize`**

Returns the plural form of the word.

```javascript
//as a function
inflect.pluralize("post"); //posts
inflect.pluralize("octopus"); //octopi
inflect.pluralize("sheep"); //sheep
inflect.pluralize("words"); //words
inflect.pluralize("the blue mailman"); //the blue mailmen
inflect.pluralize("CamelOctopus"); //CamelOctopi

//as a monad
inflect("post").pluralize().value(); //posts
inflect("octopus").pluralize().value(); //octopi
inflect("sheep").pluralize().value(); //sheep
inflect("words").pluralize().value(); //words
inflect("the blue mailman").pluralize().value(); //the blue mailmen
inflect("CamelOctopus").pluralize().value(); //CamelOctopi
```  

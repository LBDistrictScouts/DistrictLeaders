const { src, dest, series } = require('gulp');
const { performance } = require('perf_hooks');
const fs = require('fs');
const yaml = require('js-yaml');
const replace = require('gulp-replace');
const rename = require("gulp-rename");
const scan = require('gulp-scan');
const AWS = require('aws-sdk');

let replacements = yaml.safeLoad(fs.readFileSync('replacements.yml', 'utf8'));

let retrieved_variables = (
    replacements['retrieved_variables_file'] != null ?
        replacements['retrieved_variables_file'] : 'tmp/replacement_params.yml'
);
let variable_upload = (
    replacements['variable_upload_file'] != null ?
        replacements['variable_upload_file'] : 'variables.yml'
);

let env_file = (
    replacements['environment_file'] != null ?
        replacements['environment_file'] : 'environment.yml'
);

let environments = yaml.safeLoad(fs.readFileSync(env_file, 'utf8'));

function retrieveParameters(cb) {
    let parameters = [];

    replacements['placeholders'].forEach(buildParamPath)

    function buildParamPath(replacement_string, index) {
        parameters[index] = [];
        parameters[index]['string'] = '<<' + replacement_string.toUpperCase() + '>>';
        parameters[index]['path'] = '/' + replacements['application'];
        parameters[index]['path'] += '/' + environments['environment'];
        parameters[index]['path'] += '/' + replacement_string.toLowerCase();
    }

    function pathExtractor(parameterArray) {
        parameterArray = parameterArray.reduce(function (acc, obj, index) {
            acc[index] = obj['path'];
            return acc
        }, {})

        return Object.values(parameterArray);
    }

    let paths = pathExtractor(parameters);
    console.log(paths);
    let paramPromise = new AWS.SSM({'region': 'eu-west-1'});

    let factory = function(){
        var time = 0, count = 0, difference = 0, queue = [];
        return function limit(func){
            if(func) queue.push(func);
            difference = 300 - (performance.now() - time);
            if(difference <= 0) {
                time = performance.now();
                count = 0;
            }
            if(++count <= 1) (queue.shift())();
            else setTimeout(limit, difference);
        };
    };

    let limited = factory();

    // This is to show a separator when waiting.
    let prevDate = performance.now(), difference;

    paths.forEach(function(parameter) {
        let params = {
            Name: parameter,
            WithDecryption: true
        };

        limited(function(){
            /** This is to show a separator when waiting. **/
            difference = performance.now() - prevDate;
            prevDate   = performance.now();
            if(difference > 100) console.log('wait');
            /***********************************************/
            paramPromise.getParameter(params, function(err, data) {
                if (err)  {
                    console.log(err, err.stack);
                    console.log(params);
                } // an error occurred
                else {
                    try {
                        var replace_params = yaml.safeLoad(fs.readFileSync(retrieved_variables));
                    } catch (e) {
                        var replace_params = [];
                    }

                    let working_params = [];
                    if (typeof replace_params == 'object') (working_params = replace_params);
                    working_params.push(data['Parameter']);

                    fs.writeFileSync(retrieved_variables, yaml.safeDump(working_params, {
                        'styles': {
                            '!!null': 'canonical' // dump null as ~
                        },
                        'sortKeys': true        // sort object keys
                    }));
                }
            });
        });
    });

    return cb();
}


function createParameters(cb) {
    let paramFileContents = fs.readFileSync(variable_upload, 'utf8');
    let parameters = yaml.safeLoad(paramFileContents);
    let paramPromise = new AWS.SSM({'region': 'eu-west-1'});

    let factory = function(){
        var time = 0, count = 0, difference = 0, queue = [];
        return function limit(func){
            if(func) queue.push(func);
            difference = 1000 - (performance.now() - time);
            if(difference <= 0) {
                time = performance.now();
                count = 0;
            }
            if(++count <= 4) (queue.shift())();
            else setTimeout(limit, difference);
        };
    };

    let limited = factory();

    // This is to show a separator when waiting.
    let prevDate = performance.now(), difference;

    parameters.forEach(function(parameter) {
        limited(function(){
            /** This is to show a separator when waiting. **/
            difference = performance.now() - prevDate;
            prevDate   = performance.now();
            if(difference > 100) console.log('wait');
            /***********************************************/
            paramPromise.putParameter(parameter, function(err, data) {
                if (err) console.log(err, err.stack); // an error occurred
                else     console.log(data);           // successful response
            });
        });
    });

    return cb();
}

function findParameters(cb) {
    let stream = src('config/*.default.php');
    let variables = [];

    return stream.pipe(
        scan({ term: /<<[A-Z0-9_]+>>/g, fn: function (match) {
            let path = '/' + replacements['application'];
            path += '/' + environments['environment'];
            path += '/' + match.replace('<<', '').replace('>>', '').toLowerCase();

            let obj = {
                Name: path,
                Value: match,
                Type: 'String',
                Overwrite: true
            }

            function pushToArray ( variables, obj ) {
                let existingIds = variables.map((obj) => obj.Name);

                if (! existingIds.includes(obj.Name)) {
                    variables.push(obj);
                } else {
                    variables.forEach((element, index) => {
                        if (element.Name === obj.Name) {
                            variables[index] = obj;
                        }
                    });
                }
            }

            pushToArray (variables, obj);

            fs.writeFileSync(variable_upload, yaml.safeDump(variables, {
                'styles': {
                    '!!null': 'canonical' // dump null as ~
                },
                'sortKeys': true        // sort object keys
            }));
        }})
    );
}


function parseConfigFiles() {
    let stream = src('config/*.default.php').setMaxListeners(1000);

    let replacementContents = fs.readFileSync(retrieved_variables, 'utf8');
    let parameters = yaml.safeLoad(replacementContents);

    parameters.map(function replacePlaceholders(paramArray) {
        let search_key = paramArray['Name'].split('/')
        search_key = '<<' + search_key[3].toUpperCase() + '>>';
        let replacement_value = paramArray['Value'];
        if (replacement_value === 'EMPTY_STRING') (replacement_value = '');

        stream.pipe(replace(search_key, replacement_value));
    })

    return stream
        .pipe(rename(function (path) {
            path.basename = path.basename.replace('.default', '');
        }))
        .pipe(dest('config'));
}


exports.get = retrieveParameters
exports.parse = parseConfigFiles
exports.create = createParameters
exports.find = findParameters
exports.default = series(retrieveParameters, parseConfigFiles)

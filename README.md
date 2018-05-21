# Developer test submission

## JS

For the javascript exercise, assuming you do not want the numbers which are in string types, the following will suffice

```
data.filterNonNumeric = function() { 
  const result = [];
  Object.keys(this).forEach((key) => {
    if (typeof(this[key]) === "number") {
        result.push(this[key]);
    }
  });
  return result;
};
```

However if you require the numbers which are in string types then the following is more desireable

```
data.filterNonNumeric = function() { 
  const result = [];
  Object.keys(this).forEach((key) => {
	if ((typeof(this[key]) !== "object") && (!isNaN(this[key]))) {
        result.push(this[key]);
    }
  });
  return result;
};
```

## PHP

Included in this repository is the codebase for the PHP test

### Setting up

Use composer to install the required packages (phpunit for testing), and autoloader.

In docker ```docker run --rm -it -v $(pwd):/test -w /test  php:7.1-cli-alpine php ./composer.phar install```

Or using local PHP (version 7+) php ./composer.phar install

You can run the code using PHP7 through the entry point bin/run

This will work through docker with the command ```docker run --rm -it -v $(pwd):/test -w /test  php:7.1-cli-alpine php bin/run```

Specify the output target with the -o or --output flag e.g. ```docker run --rm -it -v $(pwd):/test -w /test  php:7.1-cli-alpine php bin/run -o file.csv```

Optionally, run the unit tests with ```docker run --rm -it -v $(pwd):/test -w /test  php:7.1-cli-alpine php vendor/bin/phpunit tests/DateCalculatorTest.php```


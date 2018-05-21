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


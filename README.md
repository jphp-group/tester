# Tester

[![Build Status](https://travis-ci.org/jphp-group/tester.svg?branch=master)](https://travis-ci.org/jphp-group/tester)

Unit Testing Framework for JPPM

# How to use?

1. Add `tester` dependency to `devDeps`.

```
jppm add tester -dev
```

2. Create `tests` directory in root of your package dir.
3. Create your first test class, e.g `tests/SimpleTest.php`:

```php
use tester\{TestCase, Assert};

class SimpleTest extends TestCase 
{
  function testFeature()
  {
    $actual = "expected";
    
    Assert::isEqual("expected", $actual);
  }
}
```

4. Run your tests.
```bash
jppm test
```

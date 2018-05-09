# Assert

- **class** `Assert` (`tester\Assert`)
- **source** `tester/Assert.php`

---

#### Static Methods

- `Assert ::`[`formatValue()`](#method-formatvalue)
- `Assert ::`[`fail()`](#method-fail)
- `Assert ::`[`isEqual()`](#method-isequal)
- `Assert ::`[`isIdentical()`](#method-isidentical)
- `Assert ::`[`isNull()`](#method-isnull)
- `Assert ::`[`isNotNull()`](#method-isnotnull)
- `Assert ::`[`isTrue()`](#method-istrue)
- `Assert ::`[`isFalse()`](#method-isfalse)
- `Assert ::`[`isEmpty()`](#method-isempty)
- `Assert ::`[`isNotEmpty()`](#method-isnotempty)

---
# Static Methods

<a name="method-formatvalue"></a>

### formatValue()
```php
Assert::formatValue(mixed $value): string
```

---

<a name="method-fail"></a>

### fail()
```php
Assert::fail(string $message, mixed $formatted, mixed $args): void
```

---

<a name="method-isequal"></a>

### isEqual()
```php
Assert::isEqual(mixed $expected, mixed $actual, string|null $message): void
```

---

<a name="method-isidentical"></a>

### isIdentical()
```php
Assert::isIdentical(mixed $expected, mixed $actual, string|null $message): void
```

---

<a name="method-isnull"></a>

### isNull()
```php
Assert::isNull(mixed $actual, string|null $message): void
```

---

<a name="method-isnotnull"></a>

### isNotNull()
```php
Assert::isNotNull(mixed $actual, string|null $message): void
```

---

<a name="method-istrue"></a>

### isTrue()
```php
Assert::isTrue(mixed $actual, string|null $message): void
```

---

<a name="method-isfalse"></a>

### isFalse()
```php
Assert::isFalse(mixed $actual, string|null $message): void
```

---

<a name="method-isempty"></a>

### isEmpty()
```php
Assert::isEmpty(mixed $actual, string|null $message): void
```

---

<a name="method-isnotempty"></a>

### isNotEmpty()
```php
Assert::isNotEmpty(mixed $actual, string|null $message): void
```
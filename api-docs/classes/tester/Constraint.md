# Constraint

- **class** `Constraint` (`tester\Constraint`)
- **source** `tester/Constraint.php`

**Description**

Class Constraint

---

#### Properties

- `->`[`args`](#prop-args) : `array`
- `->`[`value`](#prop-value) : `mixed`
- `->`[`evalute`](#prop-evalute) : `callable`
- `->`[`getMessage`](#prop-getmessage) : `callable`

---

#### Static Methods

- `Constraint ::`[`isNot()`](#method-isnot)
- `Constraint ::`[`isEqual()`](#method-isequal)

---

#### Methods

- `->`[`__construct()`](#method-__construct) - _Constraint constructor._
- `->`[`getMessage()`](#method-getmessage)
- `->`[`evalute()`](#method-evalute)

---
# Static Methods

<a name="method-isnot"></a>

### isNot()
```php
Constraint::isNot(tester\Constraint $constraint): tester\Constraint
```

---

<a name="method-isequal"></a>

### isEqual()
```php
Constraint::isEqual(mixed $value): tester\Constraint
```

---
# Methods

<a name="method-__construct"></a>

### __construct()
```php
__construct(mixed $value, array $args, callable $evalute, callable $getMessage): void
```
Constraint constructor.

---

<a name="method-getmessage"></a>

### getMessage()
```php
getMessage(): string
```

---

<a name="method-evalute"></a>

### evalute()
```php
evalute(mixed $other): bool
```
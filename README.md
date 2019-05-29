# DEPRECATED
This is no longer supported

# BTC\PHPMD-Rulesets

## Features

Extends phpmd with rules for BTC applications. Also add extra rules from clean code.

* Clean Code
    * ClassNameSingleResponsibility
    * MethodOneTryCatch
    * SuperfluousComment
    * InlineIf
    * MeaninglessMethodName
    * TraitPublicMethod
    * SwitchStatement
* Symfony
    * ControllerMethodName
    * EntitySimpleGetterSetter
    * EntityConstants
    * ConstructorNewOperator
    
## Installation

Open a command console, enter your project directory and execute the following command to download the latest stable version:
```bash
composer require --dev btc/phpmd-rulesets
```

OR

Composer is used for installation. Add the following lines to your ```composer.jon``` file:
```json
"require-dev": {
  "btc/phpmd-rulesets": "^1.0"
}
```

## Usage

Use [grumphp](https://github.com/phpro/grumphp) and configure phpmd task with the following lines in your ```grumphp.yml```
```yaml
phpmd:
    exclude: ['vendor']
    ruleset: ['/vendor/btc/phpmd-rulesets/Rulesets/symfony.xml', '/vendor/btc/phpmd-rulesets/Rulesets/cleancode.xml']
    triggered_by: [php]

```

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
            ruleset: [
              'BTC/PHPMD/Rulesets/symfony.xml', 
              'BTC/PHPMD/Rulesets/cleancode.xml'
            ]
            triggered_by: [php]

```
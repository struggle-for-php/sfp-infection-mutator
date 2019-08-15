struggle-for-php/sfp-infection-mutator
======================================

Mutators for infection `PHP Mutation Testing Framework`

## Mutators
 
### PregMatchIsNumeric
 - Replaces "preg_match('/\A[0-9]+\z/', '-0.12');" with "is_numeric('-0.12');"

## Install 
```sh
composer require --dev struggle-for-php/sfp-infection-mutator
```

### Setting at your `infection.json` 
```json
{
    "mutators": {
        "@default": true,
        "Sfp\\Infection\\Mutator\\Regex\\PregMatchIsNumeric": {}
    }
}
```

# json-ast

Json AST parser

## Example

```php
<?php
declare(strict_types=1);

use \Aywan\JsonAst\JsonAstParser;

$json = <<<JSON
{
    "title": "hello world!",
    "content": [
        {"type": "h1", "value": "hello"},
        {"type": "size", "value": 123}
    ],
    "props": {"width": 85.33}
}
JSON;

$ast = (new \Aywan\JsonAst\JsonAstParser())->parse();
$hello = $ast->getRoot()
    ->getProperty('content')[0]
    ->getProperty('value')
    ->getPhpValue()
;
echo $hello; // hello
```

Approximate tokens list: 
```
{, "title", :, "hello world!", ',', "content", :, [, 
{, "type", :, "h1", ',', "value", :, "hello", }, ',',
{, "type", :, "size", ',', "value", :, 123, }, 
], ',', "props", :, {, "width", :, 85.33, }, }
```
Approximate tree:
```
Object(
    null,
    [
        Scalar("title", ["hello world!"]),
        Array(
            "content",
            [
                Object(
                    null,
                    [
                        Scalar("type", ["h1"]),
                        Scalar("value", ["hello"]),
                    ],
                ),
                Object(
                    null,
                    [
                        Scalar("size", ["h1"]),
                        Scalar("value", [123]),
                    ],
                )
            ]
        ),
        Object(
            "props",
            [
                Scalar("width", [85.33]),
            ],
        ),
    ], 
)
```

## Todo

- [ ] selector, query, json-path
- [ ] optimize memory usage
- [ ] more tests
- [ ] automation

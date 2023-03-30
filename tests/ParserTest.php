<?php

declare(strict_types=1);

namespace Tests;

use Aywan\JsonAst\JsonAstParser;
use Aywan\JsonAst\Node\ArrayNode;
use Aywan\JsonAst\Node\ObjectNode;
use Aywan\JsonAst\Tokenizer\TokenData;
use Aywan\JsonAst\Tokenizer\TokenType;
use PHPUnit\Framework\TestCase;

final class ParserTest extends TestCase
{
    public function testSimple(): void
    {
        $json = <<<'JSON'
{"a":133
, "b": [
  "s", "s\n", "s\ns", 
  "s\n\t\u0000\"\f\n\rs", 
  {"s": "\n", "\u12ff": "\u0000\uffff\u1e3a"}
  , null, true, false
                                                ],
"c": {
  "a":     123, 
        "b": [
          1.2, 1.23,
          1e2, 1e-2, 1.23e3
          ,-1.2e2, -1.2, -0,
          0, 0.0, 0.000  
      ]},
    "x": [{"y":  true}, {"y": false}, {"y": null}]
}
JSON;
        $ast = (new JsonAstParser())->parse($json);

        $tokens = $ast->getTokens();

        $this->assertCount(89, $tokens->getTokens());

        $this->assertTokens(
            [
                [TokenType::LEFT_BRACE, 0],
                [TokenType::STRING, 1],
                [TokenType::COLON, 4],
                [TokenType::NUMBER, 5],
                [TokenType::COMMA, 9],
                [TokenType::STRING, 11],
                [TokenType::COLON, 14],
                [TokenType::LEFT_BRACKET, 16],
                [TokenType::STRING, 20],
                [TokenType::COMMA, 23],
                [TokenType::STRING, 25],
                [TokenType::COMMA, 30],
                [TokenType::STRING, 32],
                [TokenType::COMMA, 38],
                [TokenType::STRING, 43],
                [TokenType::COMMA, 65],
                [TokenType::LEFT_BRACE, 70],
                [TokenType::STRING, 71],
                [TokenType::COLON, 74],
                [TokenType::STRING, 76],
                [TokenType::COMMA, 80],
                [TokenType::STRING, 82],
                [TokenType::COLON, 90],
                [TokenType::STRING, 92],
                [TokenType::RIGHT_BRACE, 112],
                [TokenType::COMMA, 116],
                [TokenType::NULL, 118],
                [TokenType::COMMA, 122],
                [TokenType::TRUE, 124],
                [TokenType::COMMA, 128],
                [TokenType::FALSE, 130],
                [TokenType::RIGHT_BRACKET, 184],
                [TokenType::COMMA, 185],
                [TokenType::STRING, 187],
                [TokenType::COLON, 190],
                [TokenType::LEFT_BRACE, 192],
                [TokenType::STRING, 196],
                [TokenType::COLON, 199],
                [TokenType::NUMBER, 205],
                [TokenType::COMMA, 208],
                [TokenType::STRING, 219],
                [TokenType::COLON, 222],
                [TokenType::LEFT_BRACKET, 224],
                [TokenType::NUMBER, 236],
                [TokenType::COMMA, 239],
                [TokenType::NUMBER, 241],
                [TokenType::COMMA, 245],
                [TokenType::NUMBER, 257],
                [TokenType::COMMA, 260],
                [TokenType::NUMBER, 262],
                [TokenType::COMMA, 266],
                [TokenType::NUMBER, 268],
                [TokenType::COMMA, 285],
                [TokenType::NUMBER, 286],
                [TokenType::COMMA, 292],
                [TokenType::NUMBER, 294],
                [TokenType::COMMA, 298],
                [TokenType::NUMBER, 300],
                [TokenType::COMMA, 302],
                [TokenType::NUMBER, 314],
                [TokenType::COMMA, 315],
                [TokenType::NUMBER, 317],
                [TokenType::COMMA, 320],
                [TokenType::NUMBER, 322],
                [TokenType::RIGHT_BRACKET, 336],
                [TokenType::RIGHT_BRACE, 337],
                [TokenType::COMMA, 338],
                [TokenType::STRING, 344],
                [TokenType::COLON, 347],
                [TokenType::LEFT_BRACKET, 349],
                [TokenType::LEFT_BRACE, 350],
                [TokenType::STRING, 351],
                [TokenType::COLON, 354],
                [TokenType::TRUE, 357],
                [TokenType::RIGHT_BRACE, 361],
                [TokenType::COMMA, 362],
                [TokenType::LEFT_BRACE, 364],
                [TokenType::STRING, 365],
                [TokenType::COLON, 368],
                [TokenType::FALSE, 370],
                [TokenType::RIGHT_BRACE, 375],
                [TokenType::COMMA, 376],
                [TokenType::LEFT_BRACE, 378],
                [TokenType::STRING, 379],
                [TokenType::COLON, 382],
                [TokenType::NULL, 384],
                [TokenType::RIGHT_BRACE, 388],
                [TokenType::RIGHT_BRACKET, 389],
                [TokenType::RIGHT_BRACE, 391],
                [TokenType::LEFT_BRACE, 0],
                [TokenType::STRING, 1],
                [TokenType::COLON, 4],
                [TokenType::NUMBER, 5],
                [TokenType::COMMA, 9],
                [TokenType::STRING, 11],
                [TokenType::COLON, 14],
                [TokenType::LEFT_BRACKET, 16],
                [TokenType::STRING, 20],
                [TokenType::COMMA, 23],
                [TokenType::STRING, 25],
                [TokenType::COMMA, 30],
                [TokenType::STRING, 32],
                [TokenType::COMMA, 38],
                [TokenType::STRING, 43],
                [TokenType::COMMA, 65],
                [TokenType::LEFT_BRACE, 70],
                [TokenType::STRING, 71],
                [TokenType::COLON, 74],
                [TokenType::STRING, 76],
                [TokenType::COMMA, 80],
                [TokenType::STRING, 82],
                [TokenType::COLON, 90],
                [TokenType::STRING, 92],
                [TokenType::RIGHT_BRACE, 112],
                [TokenType::COMMA, 116],
                [TokenType::NULL, 118],
                [TokenType::COMMA, 122],
                [TokenType::TRUE, 124],
                [TokenType::COMMA, 128],
                [TokenType::FALSE, 130],
                [TokenType::RIGHT_BRACKET, 184],
                [TokenType::COMMA, 185],
                [TokenType::STRING, 187],
                [TokenType::COLON, 190],
                [TokenType::LEFT_BRACE, 192],
                [TokenType::STRING, 196],
                [TokenType::COLON, 199],
                [TokenType::NUMBER, 205],
                [TokenType::COMMA, 208],
                [TokenType::STRING, 219],
                [TokenType::COLON, 222],
                [TokenType::LEFT_BRACKET, 224],
                [TokenType::NUMBER, 236],
                [TokenType::COMMA, 239],
                [TokenType::NUMBER, 241],
                [TokenType::COMMA, 245],
                [TokenType::NUMBER, 257],
                [TokenType::COMMA, 260],
                [TokenType::NUMBER, 262],
                [TokenType::COMMA, 266],
                [TokenType::NUMBER, 268],
                [TokenType::COMMA, 285],
                [TokenType::NUMBER, 286],
                [TokenType::COMMA, 292],
                [TokenType::NUMBER, 294],
                [TokenType::COMMA, 298],
                [TokenType::NUMBER, 300],
                [TokenType::COMMA, 302],
                [TokenType::NUMBER, 314],
                [TokenType::COMMA, 315],
                [TokenType::NUMBER, 317],
                [TokenType::COMMA, 320],
                [TokenType::NUMBER, 322],
                [TokenType::RIGHT_BRACKET, 336],
                [TokenType::RIGHT_BRACE, 337],
                [TokenType::COMMA, 338],
                [TokenType::STRING, 344],
                [TokenType::COLON, 347],
                [TokenType::LEFT_BRACKET, 349],
                [TokenType::LEFT_BRACE, 350],
                [TokenType::STRING, 351],
                [TokenType::COLON, 354],
                [TokenType::TRUE, 357],
                [TokenType::RIGHT_BRACE, 361],
                [TokenType::COMMA, 362],
                [TokenType::LEFT_BRACE, 364],
                [TokenType::STRING, 365],
                [TokenType::COLON, 368],
                [TokenType::FALSE, 370],
                [TokenType::RIGHT_BRACE, 375],
                [TokenType::COMMA, 376],
                [TokenType::LEFT_BRACE, 378],
                [TokenType::STRING, 379],
                [TokenType::COLON, 382],
                [TokenType::NULL, 384],
                [TokenType::RIGHT_BRACE, 388],
                [TokenType::RIGHT_BRACKET, 389],
                [TokenType::RIGHT_BRACE, 391]
            ],
            $tokens,
            $json,
        );

        $root = $ast->getRoot();

        $this->assertInstanceOf(ObjectNode::class, $root);
        $this->assertTrue($root->hasProperty('a'));
        $this->assertEquals(133, $root->getProperty('a')->getPhpValue());

        $this->assertTrue($root->hasProperty('b'));
        $b = $root->getProperty('b');
        $this->assertInstanceOf(ArrayNode::class, $b);
        $this->assertCount(8, $b);
        $this->assertArrayHasKey(4, $b);
        $b4 = $b[4];
        $this->assertInstanceOf(ObjectNode::class, $b4);
        $this->assertTrue($b4->hasProperty('s'));
        $this->assertEquals("\n", $b4->getProperty('s')->getPhpValue());
        $this->assertNull($b[5]->getPhpValue());
        $this->assertTrue($b[6]->getPhpValue());
        $this->assertFalse($b[7]->getPhpValue());

        $this->assertTrue($root->hasProperty('x'));
        $x = $root->getProperty('x');
        $this->assertEquals(
            [['y' => true], ['y' => false], ['y' => null]],
            $x->getPhpValue(),
        );
    }

    private function assertTokens(array $expected, TokenData $tokenList, string $input): void
    {
        $tokens = $tokenList->getTokens();

        $lines = preg_split("/((\r?\n)|(\r\n?))/", $input);

        foreach ($tokens as $index => $token) {
            $this->assertArrayHasKey($index, $expected, 'less expected items then actual');
            $e = $expected[$index];

            $this->assertEquals($e[0], $token->type);
            $this->assertEquals($e[1], $token->index);

            $length = $token->endColumn - $token->startColumn + 1;

            $value = mb_substr($input, $token->index, $length);
            $this->assertEquals($value, $token->value);

            $this->assertArrayHasKey($token->line - 1, $lines, 'unexpected line number');

            $valueLine = mb_substr($lines[$token->line - 1], $token->startColumn, $length);
            $this->assertEquals($valueLine, $token->value);
        }
    }
}

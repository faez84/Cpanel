<?php
/**
 * Created by PhpStorm.
 * User: Fayez
 * Date: 11/13/2017
 * Time: 1:51 AM
 */

namespace syndex\CpanelBundle\Model;



use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
/**
 * StrToDateFunction ::= "TIMEDIFF" "(" ArithmeticPrimary "," ArithmeticPrimary ")"
 */
class StrToDate extends FunctionNode
{
    /** @var \Doctrine\ORM\Query\AST\SimpleArithmeticExpression  */
    public $firstDateExpression = null;
    /** @var \Doctrine\ORM\Query\AST\SimpleArithmeticExpression  */
    public $secondDateExpression = null;
    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->firstDateExpression = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->secondDateExpression = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'STR_TO_DATE(sclr_1, ' .
        $this->secondDateExpression->dispatch($sqlWalker) .
        ')';
    }
}
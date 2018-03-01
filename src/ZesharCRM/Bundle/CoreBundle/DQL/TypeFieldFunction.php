<?php

namespace ZesharCRM\Bundle\CoreBundle\DQL;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\Query\SqlWalker;

class TypeFieldFunction extends FunctionNode
{
    public $childEntityTitle;
    public $fieldTitle;

    public function getSql(SqlWalker $sqlWalker)
    {
        // TODO dynamic getter alias
        if ($this->childEntityTitle == 'lead') {
            $tableAlias = 'l3_';
        } elseif ($this->childEntityTitle == 'opportunity') {
            $tableAlias = 'o4_';
        } else {
            throw QueryException::semanticalError(
                'FIELD() invalid childEntityTitle.'
            );
        }

        if (!$this->fieldTitle) {
            throw QueryException::semanticalError(
                'FIELD() empty fieldTitle.'
            );
        }

//        print_r($tableAlias . '.' . $this->fieldTitle);die;

        return $tableAlias . '.' . $this->fieldTitle;
    }

    /**
     * @param Parser $parser
     */
    public function parse(Parser $parser)
    {
        $lexer = $parser->getLexer();
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $literal = $parser->Literal();
        $this->childEntityTitle = $literal->value;
        $literal = $parser->Literal();
        $this->fieldTitle = $literal->value;

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
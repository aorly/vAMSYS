<?php namespace vAMSYS\Services;

use vAMSYS\Acars;
use vAMSYS\Contracts\PirepParser as PirepParserContract;
use vAMSYS\Exceptions\NoParserException;
use vAMSYS\Exceptions\UnmatchedPirepLineException;
use vAMSYS\ParserRegex;
use vAMSYS\Pirep;

/**
 * Class PirepParser
 * @package vAMSYS\Services
 */
class PirepParser implements PirepParserContract
{
    const FUNCTION_PREFIX = 'vAMSYS\\Services\\PirepParser\\';

    private $acars;
    private $regexes;

    public function __construct($acarsId)
    {
        $this->acars = Acars::find($acarsId);
        $this->regexes = ParserRegex::where('acars_id', '=', $acarsId)->get();
    }

    public function parseLine($timestamp, $line, Pirep $pirep)
    {
        // Find what this line is!
        foreach ($this->regexes as $regex){
            $matches = [];
            if (preg_match($regex->regex, $line, $matches) === 1) {
                if (is_callable(self::FUNCTION_PREFIX . $this->acars->name . '\\' . $regex->parser . '::parse'))
                    return call_user_func(self::FUNCTION_PREFIX . $this->acars->name . '\\' . $regex->parser .
                        '::parse', $timestamp, $line, $matches, $pirep);
                throw new NoParserException();
            }
        }
        throw new UnmatchedPirepLineException();
    }
}

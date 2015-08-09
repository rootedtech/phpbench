<?php

/*
 * This file is part of the PHP Bench package
 *
 * (c) Daniel Leech <daniel@dantleech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpBench\Tests\Unit\Report\Tool;

use PhpBench\Report\Tool\Formatter;

class FormatterTest extends \PHPUnit_Framework_TestCase
{
    private $formatter;

    public function setUp()
    {
        $this->formatter = new Formatter();
    }

    /**
     * It should format numbers with thousand separators.
     */
    public function testNumbers()
    {
        $result = $this->formatter->format(100000, '!number');
        $this->assertEquals('100,000', $result);
    }

    /**
     * It should format as a percentage.
     */
    public function testPercentage()
    {
        $result = $this->formatter->format(94, '%s%%');
        $this->assertEquals('94%', $result);
    }

    /**
     * It should combine different formatters.
     */
    public function testCombination()
    {
        $result = $this->formatter->format(94000, array('!number', '%s%%'));
        $this->assertEquals('94,000%', $result);
    }
}
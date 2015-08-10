<?php

/*
 * This file is part of the PHP Bench package
 *
 * (c) Daniel Leech <daniel@dantleech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpBench\Tests\Benchmark;

use Symfony\Component\Finder\Finder;
use PhpBench\Benchmark\CollectionBuilder;

class CollectionBuilderTest extends \PHPUnit_Framework_TestCase
{
    private $benchmarkBuilder;
    private $finder;

    public function setUp()
    {
        $this->benchmarkBuilder = $this->prophesize('PhpBench\Benchmark\BenchmarkBuilder');
        $this->benchmark1 = $this->prophesize('PhpBench\Benchmark\Benchmark');
        $this->benchmark2 = $this->prophesize('PhpBench\Benchmark\Benchmark');
        $this->finder = new CollectionBuilder($this->benchmarkBuilder->reveal());
    }

    /**
     * It should return a collection of all found bench benchmarks.
     * It should not instantiate abstract classes.
     */
    public function testBuildCollection()
    {
        $this->benchmarkBuilder->build(__DIR__ . '/findertest/FooCaseBench.php', array(), array())->willReturn($this->benchmark1->reveal());
        $this->benchmarkBuilder->build(__DIR__ . '/findertest/FooCase2Bench.php', array(), array())->willReturn($this->benchmark1->reveal());
        $this->benchmarkBuilder->build(__DIR__ . '/findertest/AbstractBench.php', array(), array())->willReturn(null);
        $collection = $this->finder->buildCollection(__DIR__ . '/findertest');
        $benchmarks = $collection->getBenchmarks();

        $this->assertCount(2, $benchmarks);
        $this->assertContainsOnlyInstancesOf('PhpBench\Benchmark\Benchmark', $benchmarks);
    }
}

<?php

namespace Silly\Edition\Pimple\Test;

use Interop\Container\Pimple\PimpleInterop;
use Silly\Edition\Pimple\Application;
use Silly\Edition\Pimple\Test\Mock\SpyOutput;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\OutputInterface as Out;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_have_a_container_by_default()
    {
        $app = new Application;

        $this->assertInstanceOf(PimpleInterop::class, $app->getContainer());
    }

    /**
     * @test
     */
    public function it_should_accept_the_container_in_the_constructor()
    {
        $container = new PimpleInterop;

        $app = new Application('name', 'version', $container);

        $this->assertSame($container, $app->getContainer());
    }

    /**
     * @test
     */
    public function it_should_inject_in_callables_parameters()
    {
        $container = new PimpleInterop;

        $app = new Application('name', 'version', $container);
        $app->setAutoExit(false);
        $app->setCatchExceptions(false);

        $container['foo'] = 'bar';
        $container['Interop\Container\Pimple\PimpleInterop'] = $container;

        $app->command('greet', function (Out $output, PimpleInterop $container, $foo) use ($app) {
            if ($container !== $app->getContainer()) {
                throw new \Exception('Not the same instance');
            }
            $output->write($foo);
        });
        $this->assertOutputIs($app, 'greet', 'bar');
    }

    private function assertOutputIs(Application $app, $command, $expected)
    {
        $output = new SpyOutput;
        $app->run(new StringInput($command), $output);
        $this->assertEquals($expected, $output->output);
    }

    /**
     * Fixture method.
     * @param Out $output
     */
    public function foo(Out $output)
    {
        $output->write('hello');
    }
}

<?php

use Daycry\CronJob\Scheduler;
use Daycry\CronJob\Job;
use CodeIgniter\Test\CIUnitTestCase as TestCase;

/**
 * @internal
 */
final class SchedulerTest extends TestCase
{
    /**
     * @var Scheduler
     */
    protected $scheduler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->scheduler = new Scheduler();
    }

    public function testCallSavesTask()
    {
        $function = static function () {
            return 'Hello';
        };

        $task = $this->scheduler->call($function);

        $this->assertInstanceOf(\Closure::class, $function);
        $this->assertInstanceOf(Job::class, $task);
        $this->assertSame($function, $task->getAction());
        $this->assertSame('Hello', $task->getAction()());
    }

    public function testCommandSavesTask()
    {
        $task = $this->scheduler->command('foo:bar');

        $this->assertInstanceOf(Job::class, $task);
        $this->assertSame('foo:bar', $task->getAction());
    }

    public function testShellSavesTask()
    {
        $task = $this->scheduler->shell('foo:bar');

        $this->assertInstanceOf(Job::class, $task);
        $this->assertSame('foo:bar', $task->getAction());
    }
}

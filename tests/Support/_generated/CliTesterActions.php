<?php  //[STAMP] e5c6821684774ca69cb502f9337b5967
// phpcs:ignoreFile
namespace Yii\Tests\Support\_generated;

// This class was automatically generated by build task
// You should not change it manually as it will be overwritten on next build

trait CliTesterActions
{
    /**
     * @return \Codeception\Scenario
     */
    abstract protected function getScenario();

    
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Executes a shell command.
     * Fails if exit code is > 0. You can disable this by passing `false` as second argument
     *
     * ```php
     * <?php
     * $I->runShellCommand('phpunit');
     *
     * // do not fail test when command fails
     * $I->runShellCommand('phpunit', false);
     * ```
     * @see \Codeception\Module\Cli::runShellCommand()
     */
    public function runShellCommand(string $command, bool $failNonZero = true): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('runShellCommand', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Checks that output from last executed command contains text
     * @see \Codeception\Module\Cli::seeInShellOutput()
     */
    public function seeInShellOutput(string $text): void {
        $this->getScenario()->runStep(new \Codeception\Step\Assertion('seeInShellOutput', func_get_args()));
    }
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * [!] Conditional Assertion: Test won't be stopped on fail
     * Checks that output from last executed command contains text
     * @see \Codeception\Module\Cli::seeInShellOutput()
     */
    public function canSeeInShellOutput(string $text): void {
        $this->getScenario()->runStep(new \Codeception\Step\ConditionalAssertion('seeInShellOutput', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Checks that output from latest command doesn't contain text
     * @see \Codeception\Module\Cli::dontSeeInShellOutput()
     */
    public function dontSeeInShellOutput(string $text): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('dontSeeInShellOutput', func_get_args()));
    }
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * [!] Conditional Assertion: Test won't be stopped on fail
     * Checks that output from latest command doesn't contain text
     * @see \Codeception\Module\Cli::dontSeeInShellOutput()
     */
    public function cantSeeInShellOutput(string $text): void {
        $this->getScenario()->runStep(new \Codeception\Step\ConditionalAssertion('dontSeeInShellOutput', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     *
     * @see \Codeception\Module\Cli::seeShellOutputMatches()
     */
    public function seeShellOutputMatches(string $regex): void {
        $this->getScenario()->runStep(new \Codeception\Step\Assertion('seeShellOutputMatches', func_get_args()));
    }
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * [!] Conditional Assertion: Test won't be stopped on fail
     *
     * @see \Codeception\Module\Cli::seeShellOutputMatches()
     */
    public function canSeeShellOutputMatches(string $regex): void {
        $this->getScenario()->runStep(new \Codeception\Step\ConditionalAssertion('seeShellOutputMatches', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Returns the output from latest command
     * @see \Codeception\Module\Cli::grabShellOutput()
     */
    public function grabShellOutput(): string {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('grabShellOutput', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Checks result code. To verify a result code > 0, you need to pass `false` as second argument to `runShellCommand()`
     *
     * ```php
     * <?php
     * $I->seeResultCodeIs(0);
     * ```
     * @see \Codeception\Module\Cli::seeResultCodeIs()
     */
    public function seeResultCodeIs(int $code): void {
        $this->getScenario()->runStep(new \Codeception\Step\Assertion('seeResultCodeIs', func_get_args()));
    }
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * [!] Conditional Assertion: Test won't be stopped on fail
     * Checks result code. To verify a result code > 0, you need to pass `false` as second argument to `runShellCommand()`
     *
     * ```php
     * <?php
     * $I->seeResultCodeIs(0);
     * ```
     * @see \Codeception\Module\Cli::seeResultCodeIs()
     */
    public function canSeeResultCodeIs(int $code): void {
        $this->getScenario()->runStep(new \Codeception\Step\ConditionalAssertion('seeResultCodeIs', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Checks result code
     *
     * ```php
     * <?php
     * $I->seeResultCodeIsNot(0);
     * ```
     * @see \Codeception\Module\Cli::seeResultCodeIsNot()
     */
    public function seeResultCodeIsNot(int $code): void {
        $this->getScenario()->runStep(new \Codeception\Step\Assertion('seeResultCodeIsNot', func_get_args()));
    }
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * [!] Conditional Assertion: Test won't be stopped on fail
     * Checks result code
     *
     * ```php
     * <?php
     * $I->seeResultCodeIsNot(0);
     * ```
     * @see \Codeception\Module\Cli::seeResultCodeIsNot()
     */
    public function canSeeResultCodeIsNot(int $code): void {
        $this->getScenario()->runStep(new \Codeception\Step\ConditionalAssertion('seeResultCodeIsNot', func_get_args()));
    }
}

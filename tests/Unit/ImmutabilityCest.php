<?php

declare(strict_types=1);

namespace Yii\Tests\Acceptance;

use Yii\Framework\Runner\AbstractApplication;
use Yii\Framework\Runner\HttpApplication;
use Yii\Tests\Support\UnitTester;
use Yiisoft\ErrorHandler\ErrorHandler;

final class ImmutabilityCest
{
    public function testAbstractApplication(UnitTester $I): void
    {
        $application = new class () extends AbstractApplication {
            public function run(): void
            {
            }
        };

        $I->assertNotSame($application, $application->withBootstrapGroup(''));
        $I->assertNotSame($application, $application->withConfigPath(''));
        $I->assertNotSame($application, $application->withDebug(false));
        $I->assertNotSame($application, $application->withDiGroup(''));
        $I->assertNotSame($application, $application->withDiDelegatesGroup(''));
        $I->assertNotSame($application, $application->withDiProvidersGroup(''));
        $I->assertNotSame($application, $application->withDiTagsGroup(''));
        $I->assertNotSame($application, $application->withEnvironment(''));
        $I->assertNotSame($application, $application->withEventsGroup(''));
        $I->assertNotSame($application, $application->withNestedEventsGroups(''));
        $I->assertNotSame($application, $application->withNestedParamsGroups(''));
        $I->assertNotSame($application, $application->withParamsGroup(''));
        $I->assertNotSame($application, $application->withValidateEvents(true));
        $I->assertNotSame($application, $application->withRootPath(''));
    }

    public function testHttpApplication(UnitTester $I): void
    {
        $httpApplication = new HttpApplication();

        $I->assertNotSame($httpApplication, $httpApplication->withPublicDirectory(''));
        $I->assertNotSame($httpApplication, $httpApplication->withRuntimeDirectory(''));
        $I->assertNotSame($httpApplication, $httpApplication->withTemporaryErrorHandler($I->get(ErrorHandler::class)));
    }
}

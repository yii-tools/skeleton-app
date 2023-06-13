<?php

declare(strict_types=1);

namespace Yii\Tests\Acceptance;

use Yii\Tests\Support\AcceptanceTester;

final class NotFoundHandlerCest
{
    public function test404(AcceptanceTester $I): void
    {
        $I->amGoingTo('try to see 404 page.');
        $I->amOnPage('/');

        $I->expectTo('see 404 page.');
        $I->seeResponseCodeIs(404);
        $I->see('We were unable to find the page "/en/"');
    }
}

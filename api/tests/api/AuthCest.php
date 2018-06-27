<?php

namespace api\tests\api;

use api\tests\ApiTester;
use common\fixtures\TokenFixture;
use common\fixtures\UserFixture;

/**
 * Class LoginCest
 */
class AuthCest
{

    public function _before(ApiTester $I)
    {
        $I->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php',
            ],
            'token' => [
                'class' => TokenFixture::class,
                'dataFile' => codecept_data_dir() . 'token.php',
            ],
        ]);

    }
//    /**
//     * Load fixtures before db transaction begin
//     * Called in _before()
//     * @see \Codeception\Module\Yii2::_before()
//     * @see \Codeception\Module\Yii2::loadFixtures()
//     * @return array
//     */
   /* public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'login_data.php'
            ],
            'token' => [
                'class' => TokenFixture::class,
                'dataFile' => codecept_data_dir() . 'token.php',
            ],
        ];
    }*/

    public function badMethod(ApiTester $I)
    {
        $I->sendGET('/auth');
        $I->seeResponseCodeIs(405);
        $I->seeResponseIsJson();
    }

    public function wrongCredentials(ApiTester $I)
    {
        $I->sendPOST('/auth', [
            'username' => 'okirlin',
            'password' => 'wrong-password',
        ]);
        $I->seeResponseCodeIs(422);
        $I->seeResponseContainsJson([
            'field' => 'password',
            'message' => 'Incorrect username or password.'
        ]);
    }

    public function success(ApiTester $I)
    {
        $I->sendPOST('/auth', [
            'username' => 'okirlin',
            'password' => 'password_0',
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseJsonMatchesJsonPath('$.token');
        $I->seeResponseJsonMatchesJsonPath('$.expired');
    }







    /**
     * @param ApiTester $I
     */
    /*public function loginUser(ApiTester $I)
    {
        $I->amOnPage('/site/login');
        $I->fillField('Username', 'erau');
        $I->fillField('Password', 'password_0');
        $I->click('login-button');

        $I->see('Logout (erau)', 'form button[type=submit]');
        $I->dontSeeLink('Login');
        $I->dontSeeLink('Signup');
    }*/
}

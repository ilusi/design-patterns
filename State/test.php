<?php

include 'smartphone.php';

define(FORMATTER_ACTION, '<br />' . str_repeat('&nbsp;', 3) . '...');
define(FORMATTER_TEST, '<br />' . str_repeat('&nbsp;', 3) . '* ');
define(PASSWORD, 'password');

class SmartPhoneTest
{
    public static function displayStatus($smartPhone)
    {
        print(
            '<strong>'
            . FORMATTER_TEST . 'The device is ' . ((0 === $smartPhone->getState()) ? 'off' : 'on')
            . FORMATTER_TEST . 'The device security is ' . ($smartPhone->requirePassword() ? 'on' : 'off')
            . '</strong><br>'
        );
    }

    public static function pushButton($smartPhone)
    {
        print(FORMATTER_TEST . 'Pressing the button' . '<br />');

        $smartPhone->pushButton();
    }

    public static function provideWrongPassword($smartPhone)
    {
        print(FORMATTER_TEST . 'Providing an invalid password' . '<br />');

        $smartPhone->providePassword();
    }

    public static function provideValidPassword($smartPhone)
    {
        print(FORMATTER_TEST . 'Providing the correct password' . '<br />');

        $smartPhone->providePassword(PASSWORD);
    }

    public static function testSecurityOff()
    {
        print('<h2>Testing with password off</h2>');

        $smartPhone = new SmartPhone();

        self::displayStatus($smartPhone);
        self::pushButton($smartPhone);
        self::pushButton($smartPhone);
        self::pushButton($smartPhone);
        self::pushButton($smartPhone);
        self::pushButton($smartPhone);

        print('<hr>');
    }

    public static function testSecurityOnWithCorrectPassword()
    {
        print('<h2>Testing with correct password</h2>');

        $smartPhone = new SmartPhone();
        $smartPhone->setRequirePassword(true);
        $smartPhone->setPassword(PASSWORD);

        self::displayStatus($smartPhone);
        self::pushButton($smartPhone);
        self::provideValidPassword($smartPhone);
        self::pushButton($smartPhone);
        self::pushButton($smartPhone);

        print('<hr>');
    }

    public static function testSecurityOnWithWrongPassword()
    {
        print('<h2>Testing with wrong password</h2>');

        $smartPhone = new SmartPhone();
        $smartPhone->setRequirePassword(true);
        $smartPhone->setPassword(PASSWORD);

        self::displayStatus($smartPhone);
        self::pushButton($smartPhone);
        self::provideWrongPassword($smartPhone);
        self::provideValidPassword($smartPhone);
        self::pushButton($smartPhone);
        self::pushButton($smartPhone);

        print('<hr>');
    }
}

print('<h1>Testing smartphone.php</h1>');

try {
    SmartPhoneTest::testSecurityOff();
    SmartPhoneTest::testSecurityOnWithCorrectPassword();
    SmartPhoneTest::testSecurityOnWithWrongPassword();
} catch (Exception $e) {
    print($e);
}

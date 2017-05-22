<?php

include 'smartphone2.php';

spl_autoload_register(function($className) {
    include 'States/' . $className . '.php';
});

define(FORMATTER_ACTION, '<br />' . str_repeat('&nbsp;', 3) . '...');
define(FORMATTER_TEST, '<br />' . str_repeat('&nbsp;', 3) . '* ');

class SmartPhoneTest
{
    public static function displayStatus($smartPhone)
    {
        print(
            '<strong>'
            . FORMATTER_TEST . 'The device is ' . (($smartPhone->getState() instanceof OffState) ? 'off' : 'on')
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

        self::displayStatus($smartPhone);
        self::pushButton($smartPhone);
        self::provideWrongPassword($smartPhone);
        self::provideValidPassword($smartPhone);
        self::pushButton($smartPhone);
        self::pushButton($smartPhone);

        print('<hr>');
    }

    public static function testLockedOut()
    {
        print('<h2>Testing locked out</h2>');

        $smartPhone = new SmartPhone();
        $smartPhone->setRequirePassword(true);

        self::displayStatus($smartPhone);
        self::pushButton($smartPhone);
        self::provideWrongPassword($smartPhone);
        self::provideWrongPassword($smartPhone);
        self::provideWrongPassword($smartPhone);
        self::pushButton($smartPhone);
        self::pushButton($smartPhone);

        print('<hr>');
    }
}

print('<h1>Testing smartphone2.php</h1>');

try {
    SmartPhoneTest::testSecurityOff();
    SmartPhoneTest::testSecurityOnWithCorrectPassword();
    SmartPhoneTest::testSecurityOnWithWrongPassword();
    SmartPhoneTest::testLockedOut();
} catch (Exception $e) {
    print($e);
}

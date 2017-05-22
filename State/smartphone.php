<?php

/**
 * Context
 * A smart phone device has a power button and a display screen. To conserve
 * the battery power, the smart phone needs to have features:
 * - power off the display when the power button is pressed
 * - power on the display when the power button is pressed
 *
 * For security purpose, it must have a locking mechanism.
 *
 * Problem
 * I need to accomodate the changing flow of the smart phone internal states
 * and provide a maintainable and flexible when adding new features.
 *
 * Solution
 * Create a strategy on the smart phone to handle its various internal states.
 */

class SmartPhone
{
    const STATE_OFF = 0;
    const STATE_LOCKED = 1;
    const STATE_UNLOCKED = 2;

    private $state;
    private $requirePassword;
    private $password;

    public function __construct()
    {
        define(FORMATTER_SYS, '<br />' . '> ');

        $this->state = self::STATE_OFF;
        $this->requirePassword = false;
    }

    public function setState($state)
    {
        $this->state = (int) $state;

        return $this;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setPassword($password)
    {
        $this->password = (string) $password;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setRequirePassword($flag)
    {
        $this->requirePassword = (bool) $flag;

        return $this;
    }

    public function requirePassword()
    {
        return $this->requirePassword;
    }

    public function pushButton()
    {
        if (self::STATE_OFF == $this->state) {
            print(FORMATTER_SYS . 'The device is now on.' . '<br />');

            if ($this->requirePassword) {
                $this->setState(self::STATE_LOCKED);
            } else {
                $this->setState(self::STATE_UNLOCKED);
            }
        } else if (self::STATE_LOCKED == $this->state) {
            $this->setState(self::STATE_OFF);
        } else if (self::STATE_UNLOCKED == $this->state) {
            $this->setState(self::STATE_OFF);
        }

        $this->display();
    }

    public function providePassword($password = null)
    {
        if (self::STATE_OFF == $this->state) {
            throw new Exception(FORMATTER_SYS . 'The device needs to be turned on first.' . '<br />');
        } else if (self::STATE_LOCKED == $this->state) {
            if ($password == $this->password) {
                $this->setState(self::STATE_UNLOCKED);
            } else {
                print(FORMATTER_SYS . 'Wrong password!');
            }

            $this->display();
        } else if (self::STATE_UNLOCKED == $this->state) {
            throw new Exception(FORMATTER_SYS . 'The device security needs to be set first.' . '<br />');
        }
    }

    private function display()
    {
        if (self::STATE_OFF == $this->state) {
            print(FORMATTER_SYS . 'The device is now off.' . '<br />');
        } else if (self::STATE_LOCKED == $this->state) {
            print(FORMATTER_SYS . 'Please enter your password:' . '<br />');
        } else if (self::STATE_UNLOCKED == $this->state) {
            print(FORMATTER_SYS . '<i>You are on the main menu.</i>' . '<br />');
        }
    }
}

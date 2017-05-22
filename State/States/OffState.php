<?php

class OffState implements StateInterface
{
    private $smartPhone;

    public function __construct(SmartPhone $smartPhone)
    {
        $this->smartPhone = $smartPhone;
    }

    public function pushButton()
    {
        print(FORMATTER_SYS . 'The device is now on.' . '<br />');

        if ($this->smartPhone->requirePassword()) {
            if ($this->smartPhone->lockedOut()) {
                $this->smartPhone->setState($this->smartPhone->getLockedOutState());
            } else {
                $this->smartPhone->setState($this->smartPhone->getLockedState());
            }
        } else {
            $this->smartPhone->setState($this->smartPhone->getUnlockedState());
        }
    }

    public function providePassword($password = null)
    {
        throw new Exception(FORMATTER_SYS . 'The device needs to be turned on first.' . '<br />');
    }

    public function display()
    {
        print(FORMATTER_SYS . 'The device is now off.' . '<br />');
    }
}

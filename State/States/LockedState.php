<?php

class LockedState implements StateInterface
{
    private $smartPhone;

    public function __construct(SmartPhone $smartPhone)
    {
        $this->smartPhone = $smartPhone;
    }

    public function pushButton()
    {
        $this->smartPhone->setState($this->smartPhone->getOffState());
    }

    public function providePassword($password = null)
    {
        if ($password == $this->smartPhone->getPassword()) {
            $this->smartPhone->resetPasswordCounter();
            $this->smartPhone->setState($this->smartPhone->getUnlockedState());
        } else {
            print(FORMATTER_SYS . 'Wrong password!');

            $this->smartPhone->incrementPasswordCounter();

            if ($this->smartPhone->lockedOut()) {
                $this->smartPhone->setState($this->smartPhone->getLockedOutState());
            }
        }
    }

    public function display()
    {
        print(FORMATTER_SYS . 'Please enter your password:' . '<br />');
    }
}

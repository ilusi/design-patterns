<?php

class LockedOutState implements StateInterface
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
        throw new Exception(FORMATTER_SYS . 'The device is locked permanently.' . '<br />');
    }

    public function display()
    {
        print(FORMATTER_SYS . 'Your device is forever locked for security reason because multiple fail login attempts were made.' . '<br />');
    }
}

<?php

class UnlockedState implements StateInterface
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
        throw new Exception(FORMATTER_SYS . 'The device security needs to be set first.' . '<br />');
    }

    public function display()
    {
        print(FORMATTER_SYS . '<i>You are on the main menu.</i>' . '<br />');
    }
}

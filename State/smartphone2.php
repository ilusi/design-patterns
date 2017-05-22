<?php

define(FORMATTER_SYS, '<br />' . '> ');

class SmartPhone
{
    private $offState;
    private $lockedState;
    private $unlockedState;
    private $lockedOutState;

    private $state;
    private $requirePassword;
    private $password;
    private $passwordCounter;

    public function __construct()
    {
        $this->offState = new OffState($this);
        $this->lockedState = new LockedState($this);
        $this->unlockedState = new UnlockedState($this);
        $this->lockedOutState = new LockedOutState($this);

        $this->state = $this->offState;
        $this->requirePassword = false;
        $this->passwordCounter = (int) 0;
        $this->password = PASSWORD;
    }

    public function setState(StateInterface $state)
    {
        $this->state = $state;

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

    public function incrementPasswordCounter()
    {
        return $this->passwordCounter++;
    }

    public function resetPasswordCounter()
    {
        $this->passwordCounter = 0;
    }

    public function getPasswordCounter()
    {
        return $this->passwordCounter;
    }

    public function lockedOut()
    {
        return ($this->getPasswordCounter() >= 3);
    }

    public function pushButton()
    {
        $this->state->pushButton();
        $this->display();
    }

    public function providePassword($password = null)
    {
        $this->state->providePassword($password);
        $this->display();
    }

    private function display()
    {
        $this->state->display();
    }

    public function getOffState()
    {
        return $this->offState;
    }

    public function getLockedState()
    {
        return $this->lockedState;
    }

    public function getUnlockedState()
    {
        return $this->unlockedState;
    }

    public function getLockedOutState()
    {
        return $this->lockedOutState;
    }
}

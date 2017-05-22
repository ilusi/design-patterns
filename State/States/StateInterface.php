<?php

interface StateInterface
{
    public function pushButton();
    public function providePassword($password = null);
    public function display();
}

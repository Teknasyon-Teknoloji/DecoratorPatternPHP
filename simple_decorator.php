<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

interface eMailBody {

    public function loadBody();
}

class eMail implements eMailBody {

    public function loadBody() {
        echo "This is Main Email body.<br />";
    }

}

abstract class emailBodyDecorator implements eMailBody {

    protected $emailBody;

    public function __construct(eMailBody $emailBody) {
        $this->emailBody = $emailBody;
    }

    abstract public function loadBody();
}

class christmasEmailBody extends emailBodyDecorator {

    public function loadBody() {

        echo 'This is Extra Content for Christmas<br />';
        $this->emailBody->loadBody();
    }

}

class newYearEmailBody extends emailBodyDecorator {

    public function loadBody() {

        echo 'This is Extra Content for New Year.<br />';
        $this->emailBody->loadBody();
    }

}

/*
 *  Email with Xmas Greetings
 */

$email = new eMail();
$email = new christmasEmailBody($email);
$email = new newYearEmailBody($email);


$email->loadBody();
?>


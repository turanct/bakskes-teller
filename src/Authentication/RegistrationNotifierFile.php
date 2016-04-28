<?php

namespace Teller\Authentication;

final class RegistrationNotifierFile implements RegistrationNotifier
{
    private $file;

    public function __construct($file)
    {
        $this->file = (string) $file;
    }

    public function notify(Registration $registration, Secret $secret)
    {
        file_put_contents(
            $this->file,
            print_r($registration, true),
            FILE_APPEND
        );
    }
}

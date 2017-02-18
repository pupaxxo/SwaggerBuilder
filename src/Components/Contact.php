<?php

namespace SwagBag\Components;

use SwagBag\Patterned;

class Contact extends Component
{
    use Patterned;

    public function setName(string $name = 'My Org'): Contact
    {
        return $this->set('name', $name);
    }

    public function setUrl(string $url = 'www.my.org'): Contact
    {
        return $this->set('url', $url);
    }

    public function setEmail(string $email = 'support@my.org'): Contact
    {
        return $this->set('email', $email);
    }
}

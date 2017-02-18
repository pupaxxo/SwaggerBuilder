<?php

namespace SwagBag\Components;

class Info extends Component
{
    public function __construct(string $title = 'My App', string $version = '0.0.0-dev')
    {
        $this
            ->set('title', $title)
            ->set('version', $version);
    }

    public function setDescription(string $description = 'My API.'): Info
    {
        return $this->set('description', $description);
    }

    public function setTermsOfService(string $tos = 'Do not misuse this API.'): Info
    {
        return $this->set('termsOfService', $tos);
    }

    public function setContact(Contact $contact): Info
    {
        return $this->set('contact', $contact);
    }

    public function setLicense(License $license): Info
    {
        return $this->set('license', $license);
    }
}

<?php

namespace Teller;

use Teller\Event\BakskeWasClaimed;

interface Notifier
{
    public function askToAdmitDefeat(BakskeWasClaimed $event);
}

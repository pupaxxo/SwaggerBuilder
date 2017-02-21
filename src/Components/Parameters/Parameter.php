<?php

namespace SwagBag\Components\Parameters;

use SwagBag\Traits\Enum;
use SwagBag\Traits\Items;
use SwagBag\Traits\Length;
use SwagBag\Traits\Pattern;
use SwagBag\Traits\Range;

class Parameter extends BaseParameter
{
    use Items, Range, Length, Pattern, Enum;
}

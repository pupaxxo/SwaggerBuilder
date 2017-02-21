<?php

namespace SwagBag\Components\Params;

use SwagBag\Traits\CollectionFormat;
use SwagBag\Traits\Enum;
use SwagBag\Traits\Format;
use SwagBag\Traits\Items;
use SwagBag\Traits\Length;
use SwagBag\Traits\Pattern;
use SwagBag\Traits\Range;

class Parameter extends BaseParameter
{
    use Items, CollectionFormat, Format, Range, Length, Pattern, Enum;
}

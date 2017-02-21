<?php

namespace SwaggerBuilder\Components\Params;

use SwaggerBuilder\Traits\CollectionFormat;
use SwaggerBuilder\Traits\Enum;
use SwaggerBuilder\Traits\Format;
use SwaggerBuilder\Traits\Items;
use SwaggerBuilder\Traits\Length;
use SwaggerBuilder\Traits\Pattern;
use SwaggerBuilder\Traits\Range;

class Parameter extends BaseParameter
{
    use Items, CollectionFormat, Format, Range, Length, Pattern, Enum;
}

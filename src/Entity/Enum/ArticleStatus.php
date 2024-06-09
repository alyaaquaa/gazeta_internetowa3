<?php

namespace App\Entity\Enum;

class ArticleStatus
{
public const DRAFT = 'draft';
public const PUBLISHED = 'published';



/**
* Mapuje wartość liczbową na stałą ArticleStatus.
*
* @param int $value
*
* @return string ArticleStatus
*/
public static function from(int $value): string
{
switch ($value) {
case 1:
return self::DRAFT;
case 2:
return self::PUBLISHED;
default:
throw new \InvalidArgumentException(sprintf('Invalid value "%s" for ArticleStatus', $value));
}
}
}

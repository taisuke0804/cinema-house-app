<?php

namespace App\Consts;

class Genre
{
  public const ACTION = 1;
  public const COMEDY = 2;
  public const DRAMA = 3;
  public const HORROR = 4;
  public const ROMANCE = 5;
  public const OTHER = 6;

  public const GENRE_LIST = [
    self::ACTION => 'アクション',
    self::COMEDY => 'コメディ',
    self::DRAMA => 'ドラマ',
    self::HORROR => 'ホラー',
    self::ROMANCE => 'ロマンス',
    self::OTHER => 'その他',
  ];
}
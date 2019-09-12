<?php

namespace App;


class Country extends Qmodel
{
  protected static $permissions = [
    'view' => ['*']
  ];
}

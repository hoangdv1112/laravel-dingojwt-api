<?php

namespace App\Modules\Core\Auth\Helper\Facade;

use Illuminate\Support\Facades\Facade;

class AuthHelper extends Facade {
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'AuthHelper'; }
}

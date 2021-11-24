<?php

namespace Mediconesystems\LivewireDatatables;

class ImageColumn extends Column
{
    public $type = 'image';
    public $callback;

    public function __construct()
    {
        $this->callback = function ($value) {
            return view('datatables::image', ['value' => $value]);
        };
    }
}

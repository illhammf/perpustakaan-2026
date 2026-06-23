<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class GenericExport implements FromView
{
    public function __construct(
        protected string $view,
        protected array $data
    ) {}

    public function view(): View
    {
        return view($this->view, $this->data);
    }
}

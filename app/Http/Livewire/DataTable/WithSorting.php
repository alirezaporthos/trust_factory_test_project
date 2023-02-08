<?php

namespace App\Http\Livewire\DataTable;
use Illuminate\Support\Str;

trait WithSorting
{
    public $sortField = 'name';
    public $sortDirection = 'asc';

    public function sortBy($field)
    {
        if($this->sortField === $field){
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        }else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;

    }
    public function addSorting($query)
    {
        // this is for ignoring lowecase while sorting
        $direction = Str::upper($this->sortDirection);
        $order = $this->sortField.' COLLATE NOCASE '.$direction;

        return $query->orderByRaw($order);
    }

}

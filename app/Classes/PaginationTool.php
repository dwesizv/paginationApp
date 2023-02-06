<?php

namespace App\Classes;

class PaginationTool {

    private $currentP, $itemsPP, $parameters, $total;

    function __construct($total, $currentP = 1, $itemsPP = 10, $parameters = []) {
        $this->total = $total;
        $this->itemsPP = $itemsPP;
        $this->currentP = $currentP;
        $this->parameters = $parameters;
    }

    function first() {
        return 1;
    }

    function last() {
        return ceil($this->total / $this->itemsPP);
    }

    function links($onEachSide = 3) {
        $links = [];
        $first = [
            'number' => $this->first(),
            'text' => '&lsaquo;&lsaquo;',
            'url' => '??'
        ];
        $previous = [
            'number' => $this->previous(),
            'text' => '&lsaquo;',
            'url' => '??'
        ];
        $current = [
            'number' => $this->currentP,
            'text' => $this->currentP,
            'url' => '??'
        ];
        $next = [
            'number' => $this->next(),
            'text' => '&rsaquo;',
            'url' => '??'
        ];
        $last = [
            'number' => $this->last(),
            'text' => '&rsaquo;&rsaquo;',
            'url' => '??'
        ];
        $links[] = $first;
        $links[] = $previous;
        $testing = -$onEachSide;
        while($testing <= $onEachSide) {
            if($testing != 0) {
                $links[] = ['number' => ($this->currentP + $testing), 'url' => '??'];
            } else {
                $links[] = $current;
            }
            $testing++;
        }
        $links[] = $next;
        $links[] = $last;
        dd($links);
        return $links;
    }

    function next() {
        return min($this->currentP + 1, $this->last());
    }

    function previous() {
        return max($this->currentP - 1, 1); //Si da negativo devuelve 1
    }

}
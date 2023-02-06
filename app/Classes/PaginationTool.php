<?php

namespace App\Classes;

class PaginationTool {

    private $currentP, $itemsPP, $parameters, $total;

    function __construct($total, $currentP = 1, $parameters = [], $itemsPP = 10) {
        $this->total = $total;
        $this->itemsPP = $itemsPP;
        $this->currentP = max(intval($currentP), 1);
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
            'active' => $this->currentP != $this->first(),
            'current' => false,
            'number' => $this->first(),
            'text' => '&lsaquo;&lsaquo;',
            'url' => $this->route($this->first())
        ];
        $previous = [
            'active' => $this->currentP != $this->first(),
            'current' => false,
            'number' => $this->previous(),
            'text' => '&lsaquo;',
            'url' => $this->route($this->previous())
        ];
        $current = [
            'active' => false,
            'current' => true,
            'number' => $this->currentP,
            'text' => $this->currentP,
            'url' => $this->route($this->currentP)
        ];
        $next = [
            'active' => $this->currentP != $this->last(),
            'current' => false,
            'number' => $this->next(),
            'text' => '&rsaquo;',
            'url' => $this->route($this->next())
        ];
        $last = [
            'active' => $this->currentP != $this->last(),
            'current' => false,
            'number' => $this->last(),
            'text' => '&rsaquo;&rsaquo;',
            'url' => $this->route($this->last())
        ];
        $links[] = $first;
        $links[] = $previous;
        if($this->currentP > $onEachSide + 1) {
            $links[] = [
                'active' => false,
                'current' => false,
                'text' => '...',
            ];
        }
        $testing = -$onEachSide;
        while($testing <= $onEachSide) {
            if($testing != 0) {
                $page = $this->currentP + $testing;
                if($page > 0  && $page <= $this->last()) {
                    $links[] = [
                        'active' => true,
                        'current' => false,
                        'number' => $page,
                        'text' => $page, 
                        'url' => $this->route($page)
                    ];
                }
            } else {
                $links[] = $current;
            }
            $testing++;
        }
        if($this->currentP + $onEachSide < $this->last()) {
            $links[] = [
                'active' => false,
                'current' => false,
                'text' => '...',
            ];
        }
        $links[] = $next;
        $links[] = $last;
        //dd($links);
        return $links;
    }

    function next() {
        return min($this->currentP + 1, $this->last());
    }

    function previous() {
        return max($this->currentP - 1, 1); //Si da negativo devuelve 1
    }
    
    function current() {
        return $this->currentP;
    }
    
    private function route($page){
        $parameters = $this->parameters['parameters'];
        $parameters['page'] = $page;
        return route($this->parameters['route'], $parameters);
    }
}
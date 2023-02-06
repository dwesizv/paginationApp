<?php

namespace App\Http\Controllers;

use App\Models\Yate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use App\Classes\PaginationTool;
use App\Classes\NewPaginationTool;

class YateController extends Controller {

    const ITEMS_PER_PAGE = 10;
    const ORDER_BY = 'yate.nombre';
    const ORDER_TYPE = 'asc';

    private function getOrder($orderArray, $order, $default) {
        $value = array_search($order, $orderArray);
        if(!$value) {
            return $default;
        }
        return $value;
    }

    private function getOrderBy($order) {
        return $this->getOrder($this->getOrderBys(), $order, self::ORDER_BY);
    }

    private function getOrderBys() {
        return [
            'yate.id'           => 'b1',
            'yate.nombre'       => 'b2',
            'tipo.nombre'       => 'b3',
            'users.name'        => 'b4',
            'astillero.nombre'  => 'b5',
            'yate.descripcion'  => 'b6',
            'yate.precio'       => 'b7',
        ];
    }

    private function getOrderType($order) {
        return $this->getOrder($this->getOrderTypes(), $order, self::ORDER_TYPE);
    }

    private function getOrderTypes() {
        return [
            'asc'  => 't1',
            'desc' => 't2',
        ];
    }

    private function getOrderUrls($oBy, $oType, $q, $route) {
        $urls = [];
        $orderBys = $this->getOrderBys();
        $orderTypes = $this->getOrderTypes();
        foreach($orderBys as $indexBy => $by) {
            foreach($orderTypes as $indexType => $type) {
                if($oBy == $indexBy && $oType == $indexType) {
                    $urls[$indexBy][$indexType] = url()->full() . '#';
                } else {
                    $urls[$indexBy][$indexType] = route($route, [
                                                            'orderby'   => $by,
                                                            'ordertype' => $type,
                                                            'q'         => $q]);
                }
            }
        }
        return $urls;
    }

    function handmade(Request $request) {
        $page = $request->input('page', 1);
        $rows = 1000;
        $paginator = new PaginationTool($rows, $page);
        $links = $paginator->links();
        //$links = [];

        //parámetros
        $q = $request->input('q', '');
        $orderby = $this->getOrderBy($request->input('orderby'));
        $ordertype = $this->getOrderType($request->input('ordertype'));
        
        $select = 'select yate.id, yate.iduser, yate.idastillero, yate.idtipo, yate.nombre, yate.descripcion, yate.precio,
                       astillero.id aid, astillero.nombre anombre,
                       users.id uid, users.name uname, users.type utype, users.email uemail,
                       tipo.id tid, tipo.nombre tnombre, tipo.desde tdesde, tipo.hasta thasta
                from yate
                join users on yate.iduser = users.id
                join astillero on yate.idastillero = astillero.id
                join tipo on yate.idtipo = tipo.id';
        $where = '';
        $parameters = [];
        if($q != '') {
            $where = 'where yate.nombre like :query1 
                        or yate.id like :query2
                        or tipo.nombre like :query3
                        or users.name like :query4
                        or users.email like :query5
                        or astillero.nombre like :query6
                        or yate.descripcion like :query7
                        or yate.precio like :query8';
            $parameters = ['query1' => '%' . $q . '%',
                            'query2' => '%' . $q . '%',
                            'query3' => '%' . $q . '%',
                            'query4' => '%' . $q . '%',
                            'query5' => '%' . $q . '%',
                            'query6' => '%' . $q . '%',
                            'query7' => '%' . $q . '%',
                            'query8' => '%' . $q . '%'];
        }
        $orderby = 'order by ' . $orderby . ' ' . $ordertype;
        if($orderby != self::ORDER_BY) {
            $orderby .= ', ' . self::ORDER_BY . ' ' . self::ORDER_TYPE;
        }
        $init = ($page - 1) * self::ITEMS_PER_PAGE;
        //$init = ($paginator->current() - 1) * self::ITEMS_PER_PAGE;
        $limit = 'limit ' . $init . ', ' . self::ITEMS_PER_PAGE;
        $sql = $select . ' ' . $where . ' ' . $orderby . ' ' . $limit;
        //dd([$sql, $parameters]);
        $yates = DB::select($sql, $parameters);
        //dd([$sql, $result]);
        return view('yate.handmade',
                        ['links' => $links,
                            'order'    => $this->getOrderUrls($orderby, $ordertype, $q, 'yate.handmade'),
                            'q'     => $q,
                            'url'   => url('handmade'),
                            'yates' => $yates]);
    }

    function index(Request $request) {
        //consulta, ordenación y tipo de ordenación
        $q = $request->input('q', '');
        $orderby = $this->getOrderBy($request->input('orderby'));
        $ordertype = $this->getOrderType($request->input('ordertype'));
        
        //construcción de la consulta
        $yate = DB::table('yate')
                    ->join('users', 'users.id', '=', 'yate.iduser')
                    ->join('astillero', 'astillero.id', '=', 'yate.idastillero')
                    ->join('tipo', 'tipo.id', '=', 'yate.idtipo')
                    ->select('yate.*',
                                'astillero.nombre as anombre',
                                'tipo.nombre as tnombre', 'tipo.desde', 'tipo.hasta', 
                                'users.name as uname', 'users.email as uemail', 'users.type as utype');

        //agregando condición a la consulta, si la hay
        if($q != '') {
            $yate = $yate->where('yate.nombre', 'like', '%' . $q . '%')
                            ->orWhere('yate.id', 'like', '%' . $q . '%')
                            ->orWhere('tipo.nombre', 'like', '%' . $q . '%') //mal
                            ->orWhere('users.name', 'like', '%' . $q . '%')
                            ->orWhere('users.email', 'like', '%' . $q . '%')
                            ->orWhere('astillero.nombre', 'like', '%' . $q . '%')
                            ->orWhere('yate.descripcion', 'like', '%' . $q . '%')
                            ->orWhere('yate.precio', 'like', '%' . $q . '%');
        }

        //agregando el orden a la consulta
        $yate = $yate->orderBy($orderby, $ordertype);
        if($orderby != self::ORDER_BY) {
            $yate = $yate->orderBy(self::ORDER_BY, self::ORDER_TYPE);
        }

        //ejecutar la consulta, usando la paginación
        $yates = $yate->paginate(self::ITEMS_PER_PAGE)->withQueryString();
        
        //dd($yates);
        return view('yate.index', ['order'  => $this->getOrderUrls($orderby, $ordertype, $q, 'yate.index'),
                                    'q'     => $q,
                                    'url'   => url('yate'),
                                    'yates' => $yates]);
    }

    //**************************************************************************
    //old: primera versión, no correcta del todo

    const OLD_ORDER_BY = 'nombre';

    private function old_getOrderBy($order) {
        return $this->getOrder($this->old_getOrderBys(), $order, self::OLD_ORDER_BY);
    }

    private function old_getOrderBys() {
        return [
            'id'            => 'c1',
            'nombre'        => 'c2',
            'idtipo'        => 'c3',
            'iduser'        => 'c4',
            'idastillero'   => 'c5',
            'descripcion'   => 'c6',
            'precio'        => 'c7',
        ];
    }

    private function old_getOrderUrls($oBy, $oType, $q) {
        $urls = [];
        $orderBys = $this->old_getOrderBys();
        $orderTypes = $this->getOrderTypes();
        foreach($orderBys as $indexBy => $by) {
            foreach($orderTypes as $indexType => $type) {
                if($oBy == $indexBy && $oType == $indexType) {
                    $urls[$indexBy][$indexType] = url()->full() . '#';
                } else {
                    $urls[$indexBy][$indexType] = route('yate.oldyate', [
                                                            'orderby' => $by,
                                                            'ordertype' => $type,
                                                            'q' => $q]);
                }
            }
        }
        return $urls;
    }

    function oldyate(Request $request) {
        //orden
        $q = $request->input('q', '');
        $orderby = $this->old_getOrderBy($request->input('orderby'));
        $ordertype = $this->getOrderType($request->input('ordertype'));

        //datos
        $yate = new Yate();
        $yate = $yate->orderBy($orderby, $ordertype);
        if($orderby != self::ORDER_BY) {
            $yate = $yate->orderBy(self::ORDER_BY, self::ORDER_TYPE);
        }

        if($q != '') {
            $yate = $yate->where('nombre', 'like', '%' . $q . '%')
                            ->orWhere('id', 'like', '%' . $q . '%')
                            ->orWhere('idtipo', 'like', '%' . $q . '%') //mal
                            ->orWhere('iduser', 'like', '%' . $q . '%')
                            ->orWhere('idastillero', 'like', '%' . $q . '%')
                            ->orWhere('descripcion', 'like', '%' . $q . '%')
                            ->orWhere('precio', 'like', '%' . $q . '%');
        }

        $yates = $yate->paginate(self::ITEMS_PER_PAGE)->withQueryString();
        //dd($yates);
        /*$yates = $yate->paginate(self::ITEMS_PER_PAGE)
                        ->appends(
                            ['orderby' => $request->input('orderby'),
                                'ordertype' => $request->input('ordertype')]);*/

        //vista
        return view('yate.oldindex',
                        ['order'    => $this->old_getOrderUrls($orderby, $ordertype, $q),
                            'q'     => $q,
                            'url'   => url('oldyate'),
                            'yates' => $yates]);
    }
    //old
    //**************************************************************************
}
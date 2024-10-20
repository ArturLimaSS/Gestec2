<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $user;

    protected $empresa;

    public function  __construct()
    {
        $this->middleware(function ($request, $next) {

            $this->user = auth()->user();
            $this->empresa = $this->user ? $this->user->empresa[0] : null;

            return $next($request);
        });


        // $this->user = auth()->check() ? User::with(['empresa', 'empresaUser'])->find(auth()->user()->id) : null;
        // $this->empresa = $this->user ? $this->user->empresa[0] : null;
    }

    public function setUser($user)
    {
        if ($this->user == null) {
            $this->user = User::with(['empresa', 'empresaUser'])->find($user->id);
            $this->empresa = $this->user ? $this->user->empresa[0] : null;
        }
    }

    public static function tirarAcentos($string)
    {
        return preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $string);
    }
}

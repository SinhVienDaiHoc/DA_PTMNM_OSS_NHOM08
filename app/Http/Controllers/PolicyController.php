<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PolicyController extends Controller
{
  public function index(){
    return view('chinhsach.layoutschinhsach');
  }

   public function chinhsachchung(){
    return view('chinhsach.chinhsachchung');
  }
  public function chinhsachvanchuyen(){
    return view('chinhsach.chinhsachvanchuyen');
  }
  public function chinhsachdoitra(){
    return view('chinhsach.chinhsachdoitra');
  }
  public function chinhsachbaomat(){
    return view('chinhsach.chinhsachbaomat');
  }
  public function chinhsachthanhtoan(){
    return view('chinhsach.chinhsachthanhtoan');
  }

}

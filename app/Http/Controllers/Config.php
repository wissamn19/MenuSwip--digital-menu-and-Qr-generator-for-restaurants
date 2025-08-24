<?php
use Illuminate\Support\Facades\DB;

 function getData() {
    $owners = DB::table('')->get();
    return response()->json($owners);
}
?>
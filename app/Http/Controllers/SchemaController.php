<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Json;
use App\Models\Schema;
use Illuminate\Http\Request;

class SchemaController extends Controller
{
    public function index(Request $request)
    {
        try {
            $schema = Schema::entities($request->entities)->get();

            return Json::response($schema);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return Json::exception('Error Model ' . $debug = env('APP_DEBUG', false) == true ? $e : '');
        } catch (\Illuminate\Database\QueryException $e) {
            return Json::exception('Error Query ' . $debug = env('APP_DEBUG', false) == true ? $e : '');
        } catch (\ErrorException $e) {
            return Json::exception('Error Exception ' . $debug = env('APP_DEBUG', false) == true ? $e : '');
        }
    }

    public function store(Request $request)
    {
        try {
            $schema = new Schema();
            $schema->code = $request->code;
            $schema->name = $request->name;
            $schema->type = $request->type;
            $schema->count = $request->count;
            $schema->save();

            return Json::response($schema);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return Json::exception('Error Model ' . $debug = env('APP_DEBUG', false) == true ? $e : '');
        } catch (\Illuminate\Database\QueryException $e) {
            return Json::exception('Error Query ' . $debug = env('APP_DEBUG', false) == true ? $e : '');
        } catch (\ErrorException $e) {
            return Json::exception('Error Exception ' . $debug = env('APP_DEBUG', false) == true ? $e : '');
        }
    }
}

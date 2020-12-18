<?php
/**
 * Created by PhpStorm.
 * User: roshani
 * Date: 18/12/20
 * Time: 6:49 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use SoftDeletes;
    protected $table = "blog";
}
<?php namespace Princealikhan\Mautic\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Created by PhpStorm.
 * User: prince
 * Date: 23/11/16
 * Time: 1:15 AM
 */
class MauticConsumer extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mautic_consumer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['access_token', 'expires', 'token_type','refresh_token'];

}

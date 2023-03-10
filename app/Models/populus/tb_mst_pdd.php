<?php

namespace App\Models\populus;

use Illuminate\Database\Eloquent\Model;

class tb_mst_pdd extends Model
{
    protected $connection = 'mysql_populus';

    protected $table = 'tb_mst_pdd';

    public $timestamps = true;

    public function get_table_raw()
    {
        return $this->table;
    }

    public function get_table_conn()
    {
        return $this->connection . '.' . $this->table;
    }

    public function get_table()
    {
        return env('DB_DATABASE_POPULUS') . '.' . $this->table;
    }

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    // protected $fillable = [
    //     'nama',
    //     'password',
    // ];
}

<?php

namespace App\Models\general;

use Illuminate\Database\Eloquent\Model;

class tb_acc_sfr_tab_mdl extends Model
{
    protected $connection = 'mysql_general';

    protected $table = 'tb_acc_sfr_tab_mdl';

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
        return env('DB_DATABASE_GENERAL') . '.' . $this->table;
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

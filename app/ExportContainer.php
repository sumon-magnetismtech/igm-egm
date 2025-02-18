<?php

namespace App;

use App\Ctrack\Export;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ExportContainer extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    protected $fillable = ['export_id','blcontainer_id','contRef'];

    public function export()
    {
        return $this->belongsTo(Export::class );
    }
}

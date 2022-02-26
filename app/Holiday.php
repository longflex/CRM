<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Laralum\Laralum;
/**
 * Class Holiday
 * @package App\Models
 */
class Holiday extends Model
{
    // Don't forget to fill this array
    protected $fillable = ['date','occassion','client_id'];

    protected $guarded = ['id'];
    protected $dates = ['date'];

    public static function getHolidayByDates($startDate, $endDate){
    	if (Laralum::loggedInUser()->reseller_id == 0) {
			$client_id = Laralum::loggedInUser()->id;
		} else {
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
        if (!is_null($endDate)||!is_null($startDate)) {
            return Holiday::select(DB::raw('DATE_FORMAT(date, "%Y-%m-%d") as holiday_date'), 'occassion')->where('date', '>=', $startDate)->where('date', '<=', $endDate)->where('client_id', $client_id)->get();
        }
        return;
    }

    public static function checkHolidayByDate($date){
        if (Laralum::loggedInUser()->reseller_id == 0) {
            $client_id = Laralum::loggedInUser()->id;
        } else {
            $client_id = Laralum::loggedInUser()->reseller_id;
        }
        return Holiday::Where('date', $date)->where('client_id', $client_id)->first();
    }
}

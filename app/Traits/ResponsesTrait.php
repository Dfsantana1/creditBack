<?php
declare(strict_types=1);

namespace App\Traits;

use App\Enums\QualityOfLifeEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UploadTrait
 *
 * @category Traits
 * @package  App\Traits

 */
trait ResponsesTrait
{
    /**
     * Return Report By Age
     *
     * @param  Collection $data
     * @return JsonResponse
     */
    protected function ageReportResponse(Collection $data): JsonResponse
    {
        return $this->getDayByRangeYears($data, 95, 5, 50);

    }//end ageReportResponse()


    /**
     * Return Array by Ranges
     *
     * @param  $data
     * @param  int $topLimit
     * @param  int $jumps
     * @param  int $initialYear
     * @return JsonResponse
     */
    protected function getDayByRangeYears($data, int $topLimit, int $jumps, int $initialYear): JsonResponse
    {
        $data           = $data->sortBy('value');
        $totalResidents = $data->groupBy('id');
        $format         = 'Y-m-d';

        $numYears = $initialYear;
        $numDays  = 1;
        $ary      = [];
        $ary['< '.$numYears] = [
            'count' => $data->where('value', '>', Carbon::now()->subYears($numYears)->subDays($numDays)->format($format))->count(),
            'range' => ' < '.Carbon::now()->subYears($numYears)->subDays($numDays)->format($format),
            'data'  => $data->where('value', '>', Carbon::now()->subYears($numYears)->subDays($numDays)->format($format))->values(),
        ];
        while ($numYears < $topLimit) {
            $nDS       = ($numYears + 1);
            $rangeTo   = Carbon::now()->subYears($numYears)->subDays($numDays)->format($format);
            $numYears += $jumps;
            $numDays   = 0;
            $nDE       = $numYears;
            $rangeFrom = Carbon::now()->subYears($numYears)->subDays($numDays)->format($format);
            $numDays   = 1;
            $ary[$nDS.' to '.$nDE] = [
                'count' => $data->whereBetween('value', [$rangeFrom, $rangeTo])->count(),
                'range' => $rangeFrom.' - '.$rangeTo,
                'data'  => $data->whereBetween('value', [$rangeFrom, $rangeTo])->values(),
            ];
        }

        $ary['> '.$numYears] = [
            'count' => $data->where('value', '<', Carbon::now()->subYears($numYears)->subDays($numDays)->format($format))->count(),
            'range' => ' < '.Carbon::now()->subYears($numYears)->subDays($numDays)->format($format),
            'data'  => $data->where('value', '<', Carbon::now()->subYears($numYears)->subDays($numDays)->format($format))->values(),
        ];
        return response()
            ->json(
                [
                    'totalResidents' => $totalResidents->count(),
                    'totalResponses' => $data->count(),
                    'data'           => $ary,
                ]
            )
            ->setStatusCode(Response::HTTP_OK);

    }//end getDayByRangeYears()


    /**
     * Return Not Authorized
     *
     * @return JsonResponse
     */
    protected function notAuthorized(): JsonResponse
    {
        return response()
            ->json(['message' => 'Unauthorized'])
            ->setStatusCode(Response::HTTP_UNAUTHORIZED);

    }//end notAuthorized()


}

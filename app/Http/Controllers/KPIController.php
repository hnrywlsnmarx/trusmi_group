<?php

namespace App\Http\Controllers;

use App\Models\Lygsewingoutput;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KPIController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $kpiData = DB::select("
            SELECT 
                a.namakaryawan AS Nama,
                COUNT(CASE WHEN b.kpi = 'Sales' THEN b.kpi END) AS TargetSales,
                COUNT(CASE WHEN b.kpi = 'Sales' AND b.aktual < b.deadline THEN b.kpi END) AS ActualSales,
                CONCAT(FORMAT(COUNT(CASE WHEN b.kpi = 'Sales' AND b.aktual < b.deadline THEN b.kpi END) * 100 / COUNT(CASE WHEN b.kpi = 'Sales' THEN b.kpi END), 0), '%') AS PencapaianSales,
                CASE 
                    WHEN COUNT(CASE WHEN b.kpi = 'Sales' AND b.aktual < b.deadline THEN b.kpi END) >= c.target 
                    THEN CONCAT(c.bobot, '%') 
                    ELSE CONCAT(c.bobot - 7, '%') 
                END AS BobotSales,
                COUNT(CASE WHEN b.kpi = 'Sales' AND b.aktual > b.deadline THEN b.kpi END) AS LateSales,
                CASE 
                    WHEN COUNT(CASE WHEN b.kpi = 'Sales' AND b.aktual < b.deadline THEN b.kpi END) >= c.target 
                    THEN c.bobot 
                    ELSE c.bobot / 2 
                END AS TotalBobotSales,
                COUNT(CASE WHEN b.kpi = 'Report' THEN b.kpi END) AS TargetReport,
                COUNT(CASE WHEN b.kpi = 'Report' AND b.aktual < b.deadline THEN b.kpi END) AS ActualReport,
                CONCAT(FORMAT(COUNT(CASE WHEN b.kpi = 'Report' AND b.aktual < b.deadline THEN b.kpi END) * 100 / COUNT(CASE WHEN b.kpi = 'Report' THEN b.kpi END), 0), '%') AS PencapaianReport,
                CASE 
                    WHEN COUNT(CASE WHEN b.kpi = 'Report' AND b.aktual < b.deadline THEN b.kpi END) >= c.target 
                    THEN CONCAT(c.bobot, '%') 
                    ELSE CONCAT(c.bobot - 5, '%') 
                END AS BobotReport,
                COUNT(CASE WHEN b.kpi = 'Report' AND b.aktual > b.deadline THEN b.kpi END) AS LateReport,
                CASE 
                    WHEN COUNT(CASE WHEN b.kpi = 'Report' AND b.aktual < b.deadline THEN b.kpi END) >= c.target 
                    THEN c.bobot 
                    ELSE c.bobot / 2 
                END AS TotalBobotReport,
                CONCAT(FORMAT(
                    (
                        CASE 
                            WHEN COUNT(CASE WHEN b.kpi = 'Sales' AND b.aktual < b.deadline THEN b.kpi END) >= c.target 
                            THEN c.bobot 
                            ELSE c.bobot / 2 
                        END + 
                        CASE 
                            WHEN COUNT(CASE WHEN b.kpi = 'Report' AND b.aktual < b.deadline THEN b.kpi END) >= c.target 
                            THEN c.bobot 
                            ELSE c.bobot / 2 
                        END + 12
                    ), 0), '%') AS kpi
            FROM 
                table_kpi_marketing b
            JOIN 
                karyawan a ON b.karyawan = a.namakaryawan
            JOIN 
                kpi c ON b.kpi = c.id
            GROUP BY 
                b.karyawan, a.namakaryawan, c.target, c.bobot
            ORDER BY 
                kpi DESC
        ");

        $tasklist = DB::select("
        SELECT 
            a.namakaryawan,
            COUNT(b.tasklist) AS total_task,
            COUNT(CASE WHEN b.aktual < b.deadline THEN b.tasklist END) AS ontime,
            COUNT(CASE WHEN b.aktual > b.deadline THEN b.tasklist END) AS late,
            CONCAT(FORMAT((COUNT(CASE WHEN b.aktual < b.deadline THEN b.tasklist END) / COUNT(b.tasklist)) * 100, 0), '%') AS ontimepercentage,
            CONCAT(FORMAT((COUNT(CASE WHEN b.aktual > b.deadline THEN b.tasklist END) / COUNT(b.tasklist)) * 100, 0), '%') AS latepercentage
        FROM 
            table_kpi_marketing b
        JOIN 
            karyawan a ON b.karyawan = a.namakaryawan
        JOIN 
            kpi c ON b.kpi = c.namakpi
        JOIN 
            tasklist d ON b.tasklist = d.namatasklist
        GROUP BY 
            a.namakaryawan
    ");

        return view('kpi.index', compact('kpiData','tasklist'));
    }

    public function show($styleCode, $trnDate)
    {
        if ($styleCode == 'BOSSE FANCY OH HOOD S.9') {
            $data = Lygsewingoutput::select(
                'operatorName',
                'lygsewingoutput.destinationCode',
                // 'lygdestination.destinationName',
                DB::raw('SUM(CASE WHEN sizeName = "XS" THEN QtyOutput ELSE 0 END) AS xs'),
                DB::raw('SUM(CASE WHEN sizeName = "S" THEN QtyOutput ELSE 0 END) AS s'),
                DB::raw('SUM(CASE WHEN sizeName = "M" THEN QtyOutput ELSE 0 END) AS m'),
                DB::raw('SUM(CASE WHEN sizeName = "L" THEN QtyOutput ELSE 0 END) AS l'),
                DB::raw('SUM(CASE WHEN sizeName = "XL" THEN QtyOutput ELSE 0 END) AS xl'),
                DB::raw('SUM(CASE WHEN sizeName = "XXL" THEN QtyOutput ELSE 0 END) AS xxl'),
                DB::raw('SUM(QtyOutput) AS totalQtyOutput')
            )
                // ->join('lygdestination', 'lygsewingoutput.destinationCode', '=', 'lygdestination.destinationCode')
                ->where('styleCode', $styleCode)
                ->where('trnDate', $trnDate)
                ->groupBy('operatorName', 'lygsewingoutput.destinationCode')
                ->orderBy('operatorName', 'desc')
                ->get();
        } else if ($styleCode == 'FOOTBALL SETS EUROCUP CW N (ARGENTINA) S.9') {
            $data = Lygsewingoutput::select(
                'operatorName',
                'lygsewingoutput.destinationCode',
                // 'lygdestination.destinationName',
                DB::raw('SUM(CASE WHEN sizeName = "92" THEN QtyOutput ELSE 0 END) AS a'),
                DB::raw('SUM(CASE WHEN sizeName = "98" THEN QtyOutput ELSE 0 END) AS b'),
                DB::raw('SUM(CASE WHEN sizeName = "104" THEN QtyOutput ELSE 0 END) AS c'),
                DB::raw('SUM(CASE WHEN sizeName = "110" THEN QtyOutput ELSE 0 END) AS d'),
                DB::raw('SUM(CASE WHEN sizeName = "116" THEN QtyOutput ELSE 0 END) AS e'),
                DB::raw('SUM(CASE WHEN sizeName = "122" THEN QtyOutput ELSE 0 END) AS f'),
                DB::raw('SUM(CASE WHEN sizeName = "128" THEN QtyOutput ELSE 0 END) AS g'),
                DB::raw('SUM(CASE WHEN sizeName = "134" THEN QtyOutput ELSE 0 END) AS h'),
                DB::raw('SUM(CASE WHEN sizeName = "140" THEN QtyOutput ELSE 0 END) AS i'),
                DB::raw('SUM(CASE WHEN sizeName = "146" THEN QtyOutput ELSE 0 END) AS j'),
                DB::raw('SUM(CASE WHEN sizeName = "152" THEN QtyOutput ELSE 0 END) AS k'),
                DB::raw('SUM(QtyOutput) AS totalQtyOutput')
            )
                // ->join('lygdestination', 'lygsewingoutput.destinationCode', '=', 'lygdestination.destinationCode')
                ->where('styleCode', $styleCode)
                ->where('trnDate', $trnDate)
                ->groupBy('operatorName', 'lygsewingoutput.destinationCode')
                ->orderBy('operatorName', 'desc')
                ->get();
        }

        return response()->json($data);
    }

    public function showBak($styleCode, $trnDate)
    {
        if ($styleCode == 'BOSSE FANCY OH HOOD S.9') {
            $data = Lygsewingoutput::select(
                'operatorName',
                'lygsewingoutput.destinationCode',
                'lygdestination.destinationName',
                DB::raw('SUM(CASE WHEN sizeName = "XS" THEN QtyOutput ELSE 0 END) AS xs'),
                DB::raw('SUM(CASE WHEN sizeName = "S" THEN QtyOutput ELSE 0 END) AS s'),
                DB::raw('SUM(CASE WHEN sizeName = "M" THEN QtyOutput ELSE 0 END) AS m'),
                DB::raw('SUM(CASE WHEN sizeName = "L" THEN QtyOutput ELSE 0 END) AS l'),
                DB::raw('SUM(CASE WHEN sizeName = "XL" THEN QtyOutput ELSE 0 END) AS xl'),
                DB::raw('SUM(CASE WHEN sizeName = "XXL" THEN QtyOutput ELSE 0 END) AS xxl'),
                DB::raw('SUM(QtyOutput) AS totalQtyOutput')
            )
                ->join('lygdestination', 'lygsewingoutput.destinationCode', '=', 'lygdestination.destinationCode')
                ->where('styleCode', $styleCode)
                ->where('trnDate', $trnDate)
                ->groupBy('operatorName', 'lygsewingoutput.destinationCode', 'lygdestination.destinationName')
                ->orderBy('operatorName', 'desc')
                ->get();
        } else if ($styleCode == 'FOOTBALL SETS EUROCUP CW N (ARGENTINA) S.9') {
            $data = Lygsewingoutput::select(
                'operatorName',
                'lygsewingoutput.destinationCode',
                'lygdestination.destinationName',
                DB::raw('SUM(CASE WHEN sizeName = "92" THEN QtyOutput ELSE 0 END) AS a'),
                DB::raw('SUM(CASE WHEN sizeName = "98" THEN QtyOutput ELSE 0 END) AS b'),
                DB::raw('SUM(CASE WHEN sizeName = "104" THEN QtyOutput ELSE 0 END) AS c'),
                DB::raw('SUM(CASE WHEN sizeName = "110" THEN QtyOutput ELSE 0 END) AS d'),
                DB::raw('SUM(CASE WHEN sizeName = "116" THEN QtyOutput ELSE 0 END) AS e'),
                DB::raw('SUM(CASE WHEN sizeName = "122" THEN QtyOutput ELSE 0 END) AS f'),
                DB::raw('SUM(CASE WHEN sizeName = "128" THEN QtyOutput ELSE 0 END) AS g'),
                DB::raw('SUM(CASE WHEN sizeName = "134" THEN QtyOutput ELSE 0 END) AS h'),
                DB::raw('SUM(CASE WHEN sizeName = "140" THEN QtyOutput ELSE 0 END) AS i'),
                DB::raw('SUM(CASE WHEN sizeName = "146" THEN QtyOutput ELSE 0 END) AS j'),
                DB::raw('SUM(CASE WHEN sizeName = "152" THEN QtyOutput ELSE 0 END) AS k'),
                DB::raw('SUM(QtyOutput) AS totalQtyOutput')
            )
                ->join('lygdestination', 'lygsewingoutput.destinationCode', '=', 'lygdestination.destinationCode')
                ->where('styleCode', $styleCode)
                ->where('trnDate', $trnDate)
                ->groupBy('operatorName', 'lygsewingoutput.destinationCode', 'lygdestination.destinationName')
                ->orderBy('operatorName', 'desc')
                ->get();
        }

        return response()->json($data);
    }

    public function update(Request $request, $operatorName, $destinationCode)
    {

        $data = $request->all();
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \GuzzleHttp\Client;

class ImmigrationOffice extends Model
{
    // protected $primaryKey = 'id';
    protected $table = 'immigration_offices';
    protected $fillable = [
            'Key',
            'TableID',
            'Office',
            'OfficeType',
            'Abbrev'
        ];


    public static function fetch_immigration_offices()
    {
        $success = false;

        // $url = "http://127.0.0.1:3001/api/all_rio_and_entry_point/list";
        $url = env('ALL_RIO_AND_ENTRY_POINT_API','http://10.4.0.86:3000/api/all_rio_and_entry_point/list');

        // $StartDate = $request->input('StartDate');
        // if(is_null($StartDate)) return response()->json(["Error"=>"Start Date Is Null"]);

        $data = [];

        $client = new Client();

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            // 'API-Key' => env('API_KEY')
        ];

        try{
            $response = $client->request('POST', $url,
                [
                    'headers' => $headers,
                    'json' => $data
                ]
            );
      
            // $results = json_decode($results);

            if ($response->getStatusCode() == 200) {
                $body = $response->getBody();
                $content =$body->getContents();
                $success = true;

                // return $content;
                ImmigrationOffice::save_immigration_offices(json_decode($content, true));
                $messege = 'Successfully Fetched The Immigration Offices';
                $success = true;
            } else {
                $messege = 'Error Occured! The API replied with Status Code other than 200';
            }
        } catch (\Exception $e) {
            $messege = 'Error accessing the API URL: '. $url ;
        }

        return $success;
    }

    public static function save_immigration_offices($offices)
    {
        foreach($offices as $office)
        {
            $new_office = ImmigrationOffice::updateOrCreate(
                [
                    'Key' => $office['Key'],
                    'TableID' => $office['TableID'],
                    'OfficeType' => $office['OfficeType'],
                    'Abbrev' => $office['Abbrev'],
                ],
                [
                    'Office' => $office['Office'],
                    // 'remarks' => null
                ]
            );
    
        }
    }

    public static function get_all()
    {
        $offices = ImmigrationOffice::where('hide', 0)
            ->select(\DB::raw('CONCAT(`Office`," (",`OfficeType`,")") as Name'), 'Key')
            ->where('active', 1)
            ->orderBy('Abbrev', 'desc')
            ->get()
            ->pluck('Name','Key')
            ->toArray();

        return $offices;
    }
}

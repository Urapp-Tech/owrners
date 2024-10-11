<?php

namespace Modules\CountryManage\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Modules\CountryManage\Entities\City;
use Modules\CountryManage\Entities\Country;
use Modules\CountryManage\Entities\State;

class CityController extends Controller
{
    // display all city and add new city
    public function all_city(Request $request)
    {
        if($request->isMethod('post')){
            $request->validate([
                'country'=> 'required',
                'state'=> 'required',
                'city'=> 'required|unique:cities|max:191',
            ]);
            City::create([
                'city' => $request->city,
                'country_id' => $request->country,
                'state_id' => $request->state,
                'status' => $request->status,
            ]);
            toastr_success(__('New City Successfully Added'));
        }
        $all_countries = Country::all_countries();
        $all_states = State::all_states();

        $all_cities = City::latest()->paginate(10);
        return view('countrymanage::city.all-city',compact('all_states','all_countries','all_cities'));
    }

    // edit city
    public function edit_city(Request $request)
    {
        $request->validate([
            'city'=> 'required|max:191|unique:cities,city,'.$request->city_id,
            'country'=> 'required',
            'state'=> 'required',
        ]);
        City::where('id',$request->city_id)->update([
            'city'=>$request->city,
            'state_id'=>$request->state,
            'country_id'=>$request->country,
        ]);
        return redirect()->back()->with(toastr_success(__('City Successfully Updated')));
    }

    // change status
    public function city_status($id)
    {
        $city = City::select('status')->where('id',$id)->first();
        $city->status==1 ? $status=0 : $status=1;
        City::where('id',$id)->update(['status'=>$status]);
        return redirect()->back()->with(toastr_success(__('Status Successfully Changed')));
    }

    // delete single city
    public function delete_city($id)
    {
        City::find($id)->delete();
        return redirect()->back()->with(toastr_error(__('City Successfully Deleted')));
    }

    // delete multi city
    public function bulk_action_city(Request $request){
        City::whereIn('id',$request->ids)->delete();
        return redirect()->back()->with(toastr_success(__('Selected City Successfully Deleted')));
    }

    // import settings
    public function import_settings()
    {
        return view('countrymanage::city.import-city');
    }

    // import settings update
    public function update_import_settings(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:150000'
        ]);

        //: work on file mapping
        if ($request->hasFile('csv_file')) {
            $file = $request->csv_file;
            $extenstion = $file->getClientOriginalExtension();
            if ($extenstion == 'csv') {
                //copy file to temp folder

                $old_file = Session::get('import_csv_file_name');
                if (file_exists('assets/uploads/import/' . $old_file)) {
                    @unlink('assets/uploads/import/' . $old_file);
                }
                $file_name_with_ext = $file->getClientOriginalName();

                $file_name = pathinfo($file_name_with_ext, PATHINFO_FILENAME);
                $file_name = strtolower(Str::slug($file_name));

                $file_tmp_name = $file_name . time() . '.' . $extenstion;
                $file->move('assets/uploads/import', $file_tmp_name);

                $data = array_map('str_getcsv', file('assets/uploads/import/' . $file_tmp_name));
                $csv_data = array_slice($data, 0, 1);

                Session::put('import_csv_file_name', $file_tmp_name);
                return view('countrymanage::city.import-city', [
                    'import_data' => $csv_data,
                ]);
            }

        }
        toastr_error(__('something went wrong try again!'));
        return back();
    }

    // import city to database
    // public function import_to_database_settings(Request $request)
    // {
    //     $request->validate([
    //         'city' => 'required',
    //         'country' => 'required',
    //         'state' => 'required',
    //     ]);

    //     $file_tmp_name = Session::get('import_csv_file_name');
    //     $data = array_map('str_getcsv', file('assets/uploads/import/' . $file_tmp_name));

    //     $csv_data = current(array_slice($data, 0, 1));
    //     $csv_data = array_map(function ($item) {
    //         return trim($item);
    //     }, $csv_data);

    //     $imported_cities = 0;
    //     $x = 0;
    //     $city = array_search($request->city, $csv_data, true);
    //     $state = array_search($request->state, $csv_data, true);
    //     $country_id = array_search($request->country, $csv_data, true);

    //     foreach ($data as $index => $item) {
    //         if($x == 0){
    //             $x++;
    //             continue ;
    //         }
    //         if ($index === 0) {
    //             continue;
    //         }
    //         if (empty($item[$city])){
    //             continue;
    //         }

    //         $find_city = City::where('city', $item[$city])
    //             ->where('country_id',  $item[$country_id])
    //             ->where('state_id',  $item[$state])
    //             ->count();

    //         if ($find_city < 1) {
    //             $city_data = [
    //                 'city' => $item[$city] ?? '',
    //                 'country_id' => $item[$country_id],
    //                 'state_id' => $item[$state],
    //                 'status' => $request->status,
    //             ];
    //         }
    //         if ($find_city < 1) {
    //             City::create($city_data);
    //             $imported_cities++;
    //         }
    //     }
    //     toastr_success($imported_cities.' '. __('Cities imported successfully'));
    //     return redirect()->route('admin.city.import.csv.settings');
    // }

    public function import_to_database_settings(Request $request)
{
    // Validate incoming request
    $request->validate([
        'city' => 'required',
        'country' => 'required',
        'state' => 'required',
    ]);

    // Retrieve the temporary CSV file name from session
    $filePath = 'assets/uploads/import/' . Session::get('import_csv_file_name');

    // Open the CSV file using SplFileObject for efficient memory usage
    $file = new \SplFileObject($filePath);
    $file->setFlags(\SplFileObject::READ_CSV | \SplFileObject::SKIP_EMPTY | \SplFileObject::DROP_NEW_LINE);

    // Read the header row to map column indices
    $header = [];
    if (!$file->eof()) {
        $header = $file->fgetcsv();
        $header = array_map('trim', $header);
    }

    // Map column names to their respective indices
    $cityIndex = array_search($request->city, $header, true);
    $stateNameIndex = array_search($request->state, $header, true);
    $countryNameIndex = array_search($request->country, $header, true);

    if ($cityIndex === false || $stateNameIndex === false || $countryNameIndex === false) {
        toastr_error('Invalid CSV headers.');
        return redirect()->route('admin.city.import.csv.settings');
    }

    // Initialize counters and caches
    $imported_cities = 0;
    $chunkSize = 1000; // Define your chunk size
    $currentChunk = [];
    $countryCache = []; // Cache for country names to IDs
    $stateCache = [];   // Cache for state names to IDs per country

    // Preload all countries into cache to minimize queries
    $allCountries = Country::pluck('id', 'country')->toArray();
    $countryCache = $allCountries;

    // Preload all states into cache to minimize queries
    $allStates = State::pluck('id', 'state')->toArray();
    $stateCache = $allStates;

    // Process the CSV file line by line
    while (!$file->eof()) {
        $row = $file->fgetcsv();
        if ($row === false || count($row) < max($cityIndex, $stateNameIndex, $countryNameIndex) + 1) {
            continue; // Skip invalid rows
        }

        $cityName = trim($row[$cityIndex]);
        $stateName = trim($row[$stateNameIndex]);
        $countryName = trim($row[$countryNameIndex]);

        if (empty($cityName) || empty($stateName) || empty($countryName)) {
            continue; // Skip incomplete rows
        }

        $currentChunk[] = [
            'city' => $cityName,
            'state_name' => $stateName,
            'country_name' => $countryName,
            'status' => $request->status,
        ];

        // When chunk size is reached, process the chunk
        if (count($currentChunk) >= $chunkSize) {
            $imported_cities += $this->processChunk($currentChunk, $countryCache, $stateCache);
            $currentChunk = []; // Reset chunk
        }
    }

    // Process any remaining records in the last chunk
    if (count($currentChunk) > 0) {
        $imported_cities += $this->processChunk($currentChunk, $countryCache, $stateCache);
    }

    toastr_success($imported_cities . ' ' . __('Cities imported successfully'));
    return redirect()->route('admin.city.import.csv.settings');
}

/**
 * Process a chunk of records: resolve IDs and insert new cities.
 *
 * @param array $chunk
 * @param array &$countryCache
 * @param array &$stateCache
 * @return int Number of cities imported in this chunk
 */
private function processChunk(array $chunk, array &$countryCache, array &$stateCache)
{
    // Group records by country name
    $grouped = [];
    foreach ($chunk as $record) {
        $grouped[$record['country_name']][] = $record;
    }

    $citiesToInsert = [];

    foreach ($grouped as $countryName => $records) {
        // Resolve country ID from cache
        if (isset($countryCache[$countryName])) {
            $countryId = $countryCache[$countryName];
        } else {
            // If country not found, skip these records or handle as needed
            continue;
        }

        foreach ($records as $record) {
            $stateName = $record['state_name'];

            // Resolve state ID from cache
            if (isset($stateCache[$stateName])) {
                $stateId = $stateCache[$stateName];
            } else {
                // If state not found, skip or handle accordingly
                continue;
            }

            $citiesToInsert[] = [
                'city' => $record['city'],
                'country_id' => $countryId,
                'state_id' => $stateId,
                'status' => $record['status'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
    }

    if (empty($citiesToInsert)) {
        return 0;
    }

    // Remove duplicates based on city, country_id, and state_id
    $uniqueCities = collect($citiesToInsert)->unique(function ($item) {
        return strtolower($item['city']) . '_' . $item['country_id'] . '_' . $item['state_id'];
    })->toArray();

    // Fetch existing cities to avoid duplicates
    $existingCities = City::where(function ($query) use ($uniqueCities) {
        foreach ($uniqueCities as $city) {
            $query->orWhere(function ($q) use ($city) {
                $q->where('city', $city['city'])
                  ->where('country_id', $city['country_id'])
                  ->where('state_id', $city['state_id']);
            });
        }
    })->get(['city', 'country_id', 'state_id']);

    // Create a unique key for existing cities
    $existingKeys = $existingCities->map(function ($item) {
        return strtolower($item->city) . '_' . $item->country_id . '_' . $item->state_id;
    })->toArray();

    // Filter out cities that already exist
    $newCities = array_filter($uniqueCities, function ($city) use ($existingKeys) {
        $key = strtolower($city['city']) . '_' . $city['country_id'] . '_' . $city['state_id'];
        return !in_array($key, $existingKeys);
    });

    if (empty($newCities)) {
        return 0;
    }

    // Insert new cities in bulk
    City::insert($newCities);

    return count($newCities);
}


    // pagination
    function pagination(Request $request)
    {
        if($request->ajax()){
            $all_cities = City::latest()->paginate(10);
            return view('countrymanage::city.search-result', compact('all_cities'))->render();
        }
    }

    // search city
    public function search_city(Request $request)
    {
        $all_cities= City::where('city', 'LIKE', "%". strip_tags($request->string_search) ."%")
            ->paginate(10);
        if($all_cities->total() >= 1){
            return view('countrymanage::city.search-result', compact('all_cities'))->render();
        }else{
            return response()->json([
                'status'=>__('nothing')
            ]);
        }
    }

}

<?php

namespace App\Http\Services;

class UploadService {
    public function store($request) {
        if($request->hasFile('file')) {
            try {
                $name =  $request->file('file')->getClientOriginalName();
                $link = 'uploads/' .date('Y/m/d');
                $request->file('file')->storeAs(
                    'public/'. $link, $name
                );

                return '/storage/'. $link. '/'. $name;
            }
            catch(exception $e) {
                return false;
            }
        }
    }
}

<?php

namespace App\Additional;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
//test commit3
class Export
{
    public static function export($class)
    {
        $models = $class::all();

        if (!File::exists(public_path() . "/files")) {
            File::makeDirectory(public_path() . "/files");
        }

        $filename = public_path("files/" . $class::TABLE . ".csv");

        $handle = fopen($filename, 'w');

        $fields = Schema::getColumnListing($class::TABLE);

        fputcsv($handle, $fields);
        $values = [];

        foreach ($models as $model) {
            foreach ($fields as $field) {
                $values[] = $model->$field;
            }

            fputcsv($handle, $values);

            $values = [];
        }

        fclose($handle);

        return Storage::disk('s3')->put('user-uploads', File::get($filename));
    }
}

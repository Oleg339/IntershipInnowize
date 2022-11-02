<?php

namespace App\Additional;

use App\Mail\Products;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ImportProducts
{
    public function import()
    {
        $products = Product::all();

        if (!File::exists(public_path() . "/files")) {
            File::makeDirectory(public_path() . "/files");
        }

        $filename = public_path("files/products.csv");

        $handle = fopen($filename, 'w');

        fputcsv($handle, [
            "Type",
            "Name",
            "Company",
            "Release Date",
            "Cost(BYN)"
        ]);

        foreach ($products as $product) {
            fputcsv($handle, [
                $product->type,
                $product->name,
                $product->company,
                $product->release_date,
                $product->cost
            ]);
        }

        fclose($handle);

        $contents = Storage::disk('s3')->put('user-uploads', File::get($filename));

        if ($contents) {
            Mail::to(auth()->user()->email)->send(new Products());
        }

        return redirect()->route('products');
    }
}
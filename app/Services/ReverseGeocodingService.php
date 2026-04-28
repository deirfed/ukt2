<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ReverseGeocodingService
{
    public function getAddress($lat, $lng)
    {
        if (!$lat || !$lng) {
            return null;
        }

        $url = "https://nominatim.openstreetmap.org/reverse?format=json&lat=$lat&lon=$lng";

        try {
            $response = Http::withHeaders([
                'User-Agent' => env('APP_NAME', 'TideUpIndustries')
            ])->get($url);

            if ($response->successful()) {
                $data = $response->json();

                return $data['display_name'] ?? null;

            // // Ambil elemen address
            // $address = $data['address'] ?? [];

            // $road   = $address['road']   ?? null;
            // $suburb = $address['suburb'] ?? null;

            // // City hierarchy (pilih yang tersedia)
            // $city = $address['city']
            //     ?? $address['county']
            //     ?? $address['town']
            //     ?? $address['village']
            //     ?? null;

            // // Gabungkan elemen yang ada
            // $parts = array_filter([$road, $suburb, $city]);

            //     // Jika ada yang terisi, pakai ini
            //     if (!empty($parts)) {
            //         return implode(', ', $parts);
            //     }

            //     // Fallback: display_name
            //     return $data['display_name'] ?? null;
            }
        } catch (\Exception $e) {
            return null;
        }

        return null;
    }
}

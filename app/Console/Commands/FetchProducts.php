<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Log;

class FetchProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Products using packt api.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try{
            echo "Execution Started \n";
            ini_set('max_execution_time', 10800);
            $endpoint = "https://api.packt.com/api/v1/products";
            $client = new \GuzzleHttp\Client();
            $token = "QJpiYjqtaIzNuEDfR0bUfrVRBSTT2PLCVqQZtJ4D";
            $limit = 100;

            $response = $client->request('GET', $endpoint, ['query' => [
                'token' => $token,
                'limit' => $limit,
            ]]);

            $statusCode = $response->getStatusCode();
            $content = json_decode($response->getBody(), true);

            if (!empty($content['products'])) {
                $product_data = [];
                foreach($content['products'] as $key=>$product) {
                    if (Product::where("packt_id", $product["id"])->count()) {
                        continue;
                    }
                    $product_data[$key] = [
                        "packt_id"          => $product["id"],
                        "isbn13"            => $product["isbn13"],
                        "title"             => $product["title"],
                        "publication_date"  => $product["publication_date"],
                        "concept"           => $product["concept"],
                        "language"          => $product["language"],
                        "tool"              => $product["tool"],
                        "vendor"            => $product["vendor"],
                        "authors"           => implode(",",$product["authors"]),
                        "created_at"        => date("Y-m-d H:i:s"),
                        "updated_at"        => date("Y-m-d H:i:s"),
                    ];
                    try {
                        $content_end_point = "https://api.packt.com/api/v1/products/".$product["id"];
                        $content_response = $client->request('GET', $content_end_point, ['query' => [
                            'token' => $token,
                        ]]);
                        $statusCode = $content_response->getStatusCode();
                        if ($statusCode == 200) {
                            $product_content = json_decode($content_response->getBody(), true);
                            if (!empty($product_content)) {
                                $product_data[$key] = $product_data[$key] + [
                                    "product_type"  => $product_content['product_type'],
                                    "category"      => $product_content['category'],
                                    "tagline"       => $product_content['tagline'],
                                    "pages"         => $product_content['pages'],
                                    "length"        => $product_content['length'],
                                    "url"           => $product_content['url'],
                                    "image"         => $product_content['images']['small'] . "?token=$token",
                                ];
                            }
                        }
                    } catch (\Exception $e) {
                        Log::error($e->getMessage());
                        $product_data[$key] = $product_data[$key] + [
                            "product_type"  => null,
                            "category"      => null,
                            "tagline"       => null,
                            "pages"         => null,
                            "length"        => null,
                            "url"           => null,
                            "image"         => null,
                        ];
                    }
                }
                if (!empty($product_data)) {
                    Product::insert($product_data);
                }
            }
            echo "Success";
            Log::info("Product fetched successfully.");
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}

<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Product;
use DB;
use Log;
use DOMDocument;
use Mail;

class Kernel extends ConsoleKernel {

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
            //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {
        $schedule->call(function () {
            // Log::error("Cron running " . date('H:i:s'));
            $order_data = DB::table('order_emails')->get();
            if ($order_data->toArray()) {
                foreach ($order_data as $value) {
                    $data = (array) json_decode($value->order_data);
                    Mail::send('auth.emails.status_invoice', $data, function($message) use ($data) {
                        $message->from('autolighthouseplus@gmail.com', " Welcome To Autolighthouse");
                        if ($data['order']->order_status == 'shipped')
                            $message->to($data['email'])->subject('Autolighthouse Store:Order shipped #' . $data['order']->id);
                        else
                            $message->to($data['email'])->subject('Autolighthouse Store:Order completed #' . $data['order']->id);
                    });
                    DB::table('order_emails')->where('id', '=', $value->id)->delete();
                }
            }
        })->everyFiveMinutes();

        $schedule->call(function () {
            $products = Product::get();
            $dom = new DOMDocument('1.0', 'UTF-8');
            $xmlRoot = $dom->createElement("rss");
            $xmlRoot = $dom->appendChild($xmlRoot);
            $xmlRoot->setAttribute('version', '2.0');
            $xmlRoot->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:g', "http://base.google.com/ns/1.0");

            $channelNode = $xmlRoot->appendChild($dom->createElement('channel'));
            $channelNode->appendChild($dom->createElement('title', 'Auto light house'));
            $channelNode->appendChild($dom->createElement('link', url('/')));

            foreach ($products as $key => $product) {
                       if($product->price == 0)
                           $availability = "out of stock";
                       else
                           $availability = "in stock";
                $itemNode = $channelNode->appendChild($dom->createElement('item'));
                $itemNode->appendChild($dom->createElement('g:id'))->appendChild($dom->createTextNode($product->sku));
                $itemNode->appendChild($dom->createElement('title'))->appendChild($dom->createTextNode($product->product_name));
                $itemNode->appendChild($dom->createElement('g:description'))->appendChild($dom->createTextNode($product->product_name));
                $itemNode->appendChild($dom->createElement('link'))->appendChild($dom->createTextNode(route('products', $product->product_slug)));
                $itemNode->appendChild($dom->createElement('g:price'))->appendChild($dom->createTextNode($product->price." USD"));
                $itemNode->appendChild($dom->createElement('g:availability'))->appendChild($dom->createTextNode($availability));
                $itemNode->appendChild($dom->createElement('g:google_product_category'))->appendChild($dom->createTextNode($product->get_category->name));
                $itemNode->appendChild($dom->createElement('g:identifier_exists'))->appendChild($dom->createTextNode("no"));
                $itemNode->appendChild($dom->createElement('g:condition'))->appendChild($dom->createTextNode($product->part_type));
               

                if (isset($product->product_details->product_images) && $product->product_details->product_images != null) {
                    $product_images = json_decode($product->product_details->product_images);
                    foreach ($product_images as $i => $image) {
                        if ($i == 0)
                            $itemNode->appendChild($dom->createElement('g:image_link'))->appendChild($dom->createTextNode(url(asset('/product_images') . '/' . $image)));
                        else
                            $itemNode->appendChild($dom->createElement('g:additional_image_link'))->appendChild($dom->createTextNode(url(asset('/product_images') . '/' . $image)));
                    }
                }
            }
            $dom->formatOutput = true;
            $dom->save(base_path('public/xml/products.xml'));
        })->everyFiveMinutes();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands() {
        require base_path('routes/console.php');
    }

}

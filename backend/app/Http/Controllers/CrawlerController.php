<?php

namespace App\Http\Controllers;

use Goutte\Client;
use Illuminate\Http\Request;
use Symfony\Component\HttpClient\HttpClient;

class CrawlerController extends Controller
{
    /**
     * Consult news
     */
    public function consult(Request $request)
    {
        $nodes = [];
        $client = new Client();
        $crawler = $client->request('GET', 'https://www.google.com.mx/search?tbm=nws&q=coronavirus+mexico&oq=coronavirus+mexico');
        //dd($crawler);
        $crawler->filter('div#top_nav')->each(function ($node) {
            print $node->text()."\n";
            dd($node);
            array_push($nodes, $node);
        });
        return response()->json(['status' => 'success', 'information' => $nodes, 'crawler' => $crawler], 200);
    }
}

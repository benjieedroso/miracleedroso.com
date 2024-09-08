<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use League\Flysystem\Filesystem;
use Spatie\Dropbox\Client;
use Spatie\FlysystemDropbox\DropboxAdapter;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     private string $path = '/dropboxpath';

    public function index()
    {
        //  $client = new Client(env('DROPBOX_TOKEN'));
        // $adapter = new DropboxAdapter($client);
        // $folders = $client->listFolder($this->path);
        // dd($folders);
        return view('index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $client = new Client(env('DROPBOX_TOKEN'));
        $content = file_get_contents(__DIR__ . '/Benjie_Edroso.pdf');
        $client->upload('/dropboxpath/Benjie_Edroso.pdf', $content, $mode='add');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function downloadFile(Request $request){
        $filename = $request->query->get('filename');
        $client = new Client(env('DROPBOX_TOKEN'));
        $adapter = new DropboxAdapter($client);
        $file = $adapter->getUrl("$this->path/$filename");
        dd($file);
    }

    public function search(Request $request){
        $query = $request->input('query');
        $client = new Client(env('DROPBOX_TOKEN'));
        $data = $client->search($query);
        // return view('index', ['data' => $searchResult]);
        // $name = $data["matches"][0]["metadata"]["metadata"]["name"];
        // return view('index', ['data' => $data]);
        $viewData = [ 
            "name" => "",
            "size" => "",
            "client_modified" => "",
        ];

        $keys = array_keys($viewData);
        $keysLength = count($keys) - 1;

        $length = count($data["matches"]);
        for($i = 0; $i < $length; $i++){
          $viewData[$keys[$keysLength]] = $data["matches"][$i]["metadata"]["metadata"][$keys[$keysLength]];
        }

        dd($viewData);
        
    }

    public function deleteDoc(Request $request){
        $client = new Client(env('DROPBOX_TOKEN'));
        $client->delete("$this->path/Benjie_Edroso.pdf");
    }

    public function updateDoc(Request $request){
        $client = new Client(env("DROPBOX_TOKEN"));
        $client->delete("$this->path/Benjie_Edroso.pdf");
        $content = file_get_contents(__DIR__ . "/Benjie_Edroso2.pdf");
        $client->upload("$this->path/Benjie_Edroso2.pdf", $content, $mode = "add");
    }

    public function getDocLink(Request $request) : string
    {
        $client = new Client(env("DROPBOX_TOKEN"));
        $link = $client->getTemporaryLink("$this->path/Benjie_Edroso2.pdf");
        return $link;
    }

    
}

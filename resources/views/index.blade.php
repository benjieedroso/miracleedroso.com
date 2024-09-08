<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body>
   <form action="/document/search" method="POST">
    @csrf
        <input type="text" name="query" id="query" placeholder="Search">
        <button type="submit">Submit</button>
   </form>
    <ul>
 
    <div value='{{$length = count($data["matches"]) }}'></div>
    
    @for($i = 0; $i < $length; $i++)
        <li>{{ $data["matches"][$i]["metadata"]["metadata"]["name"]}}</li>
    @endfor
   </ul>
</body>
</html>
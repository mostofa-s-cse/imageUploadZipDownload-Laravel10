<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload</title>
</head>
<body>
    @if (session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <form action="{{ route('image.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="images[]" multiple accept="image/*">
        <button type="submit">Upload</button>
    </form>

    <a href="{{ route('image.download') }}">Download All Images as Zip</a>
    {{-- <a href="{{ route('image.download', ['id' => 1]) }}">Download All Images as Zip</a> --}}
    <br/>
    <a href="{{ route('image.singleDownload', ['id' => 12]) }}">singleDownload Images as Zip</a>

</body>
</html>

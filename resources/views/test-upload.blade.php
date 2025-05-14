<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test File Upload</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .alert {
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .image-preview {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .image-preview img {
            max-width: 100%;
            height: auto;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Test File Upload</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (isset($success) && $success)
            <div class="alert alert-success">
                {{ $message }}
            </div>
            
            <div class="image-preview">
                <h3>Uploaded Image:</h3>
                <p>Path: {{ $path }}</p>
                <p>URL: {{ $url }}</p>
                <img src="{{ $url }}" alt="Uploaded Image">
            </div>
        @endif

        @if (isset($error) && $error)
            <div class="alert alert-danger">
                {{ $message }}
            </div>
        @endif

        <form action="{{ route('test.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="test_image">Select Image:</label>
                <input type="file" name="test_image" id="test_image">
            </div>
            <button type="submit">Upload Test Image</button>
        </form>
        
        <div style="margin-top: 20px;">
            <h3>Debugging Info:</h3>
            <p>Storage Path: {{ storage_path('app/public') }}</p>
            <p>Public Path: {{ public_path('storage') }}</p>
            <p>Storage Link Exists: {{ file_exists(public_path('storage')) ? 'Yes' : 'No' }}</p>
        </div>
    </div>
</body>
</html>
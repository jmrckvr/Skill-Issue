<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Logo Upload Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        input[type="file"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }
        button:hover {
            background-color: #45a049;
        }
        .info {
            background-color: #e3f2fd;
            padding: 15px;
            border-left: 4px solid #2196F3;
            margin-bottom: 20px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Logo Upload Test</h1>
        
        <div class="info">
            <strong>Instructions:</strong>
            <ol>
                <li>Select a PNG or JPG image (max 2MB)</li>
                <li>Click Upload</li>
                <li>After upload, go to http://127.0.0.1:8000/home to see if logo appears on jobs</li>
            </ol>
        </div>

        <form action="{{ route('employer.company.logo.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label for="logo">Select Logo Image:</label>
                <input type="file" id="logo" name="logo" accept="image/*" required>
                <small style="color: #666; display: block; margin-top: 5px;">Supported formats: PNG, JPG, GIF, WebP (Max 2MB)</small>
            </div>

            <button type="submit">Upload Logo</button>
        </form>

        @if ($errors->any())
            <div style="background-color: #ffebee; padding: 15px; margin-top: 20px; border-left: 4px solid #f44336; border-radius: 4px; color: #c62828;">
                <strong>Errors:</strong>
                <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div style="background-color: #e8f5e9; padding: 15px; margin-top: 20px; border-left: 4px solid #4CAF50; border-radius: 4px; color: #2e7d32;">
                <strong>Success!</strong> {{ session('success') }}
            </div>
        @endif
    </div>
</body>
</html>

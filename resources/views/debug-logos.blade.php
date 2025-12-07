<!DOCTYPE html>
<html>
<head>
    <title>Debug Logo Paths</title>
</head>
<body>
    <h1>Debugging Logo Paths</h1>
    <p>Check what URLs are being generated...</p>
    
    <h2>Test Asset URLs:</h2>
    <ul>
        <li><code>asset('storage/company-logos/test.png')</code> = <strong id="url1"></strong></li>
        <li><code>asset('storage/' . 'company-logos/test.png')</code> = <strong id="url2"></strong></li>
        <li><code>asset('logos/test.png')</code> = <strong id="url3"></strong></li>
    </ul>

    <h2>Checking Public/Storage Access:</h2>
    <p>Test image from storage:</p>
    <img src="/storage/company-logos/test.png" alt="Test from storage" style="border: 1px solid red; width: 100px; height: 100px;">

    <script>
        // These will be replaced by Laravel Blade
        document.getElementById('url1').textContent = "{{ asset('storage/company-logos/test.png') }}";
        document.getElementById('url2').textContent = "{{ asset('storage/' . 'company-logos/test.png') }}";
        document.getElementById('url3').textContent = "{{ asset('logos/test.png') }}";
    </script>
</body>
</html>

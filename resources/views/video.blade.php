<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>Video Samenvatter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        input[type="url"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            padding: 12px 20px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #1e40af;
        }

        h2 {
            color: #111827;
        }

        p {
            line-height: 1.6;
        }

        .tags span {
            background: #e0e7ff;
            padding: 5px 10px;
            margin: 3px;
            border-radius: 5px;
            display: inline-block;
        }

        .video-container {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Video Samenvatter</h1>

        <form action="{{ route('video.fetch') }}" method="POST">
            @csrf
            <input type="url" name="url" placeholder="Plak YouTube URL hier" required>
            <button type="submit">Samenvatten</button>
        </form>

        @isset($video)
            <div class="video-container">
                <h2>{{ $video->title }}</h2>
                <img src="{{ $video->thumbnail_url }}" alt="thumbnail" style="max-width:100%;">
                <p><strong>Kanaal:</strong> {{ $video->channel_name }}</p>
            </div>

            <h3>Samenvatting:</h3>
            <p>{{ $summary_long }}</p>

            <h3>Trefwoorden:</h3>
            <div class="tags">
                @foreach($keywords as $tag)
                    <span>{{ $tag }}</span>
                @endforeach
            </div>

            <h3>Sentiment:</h3>
            <p>{{ $sentiment }}</p>
        @endisset
    </div>
</body>

</html>
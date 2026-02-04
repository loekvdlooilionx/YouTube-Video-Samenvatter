<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouTube Video Samenvatter</title>
    <style>
        /* Algemene stijl */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        /* Formulier stijl */
        form {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
            gap: 10px;
        }

        input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #007BFF;
            border: none;
            color: white;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Foutmeldingen */
        .errors {
            color: #e74c3c;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Video details */
        .video-wrapper {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .thumbnail img {
            max-width: 320px;
            border-radius: 12px;
        }

        .details {
            flex: 1;
            min-width: 300px;
        }

        .details h2 {
            margin-top: 0;
            color: #222;
        }

        .details p {
            line-height: 1.6;
            color: #555;
        }

        .summary {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
            border-left: 5px solid #007BFF;
        }

        .summary h3 {
            margin-top: 0;
            color: #007BFF;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .video-wrapper {
                flex-direction: column;
                align-items: center;
            }

            .details {
                min-width: 100%;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>YouTube Video Samenvatter</h1>

        <form action="{{ route('video.fetch') }}" method="POST">
            @csrf
            <input type="text" name="url" placeholder="Plak YouTube URL hier" value="{{ old('url') }}" required>
            <input type="submit" value="Bekijk video">
        </form>

        @if($errors->any())
            <div class="errors">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(isset($video))
            <div class="video-wrapper">
                <div class="thumbnail">
                    <img src="{{ $video['snippet']['thumbnails']['medium']['url'] }}" alt="Thumbnail">
                </div>
                <div class="details">
                    <h2>{{ $video['snippet']['title'] }}</h2>
                    <p><strong>Kanaal:</strong> {{ $video['snippet']['channelTitle'] }}</p>
                    <p><strong>Beschrijving:</strong> {{ $video['snippet']['description'] }}</p>
                    <p><strong>Views:</strong> {{ number_format($video['statistics']['viewCount']) }}</p>
                    <p><strong>Duur:</strong> {{ $video['contentDetails']['duration'] }}</p>
                    <p><strong>Gepubliceerd op:</strong>
                        {{ \Carbon\Carbon::parse($video['snippet']['publishedAt'])->format('d-m-Y') }}</p>

                    <div class="summary">
                        <h3>Korte Samenvatting:</h3>
                        <p>{{ $summary_short }}</p>
                    </div>
                </div>
            </div>
        @endif

    </div>

</body>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Folder Grid</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            width: 60%;
            text-align: center;
        }

        .folder-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s;
        }

        .folder-item:hover {
            transform: scale(1.05);
        }

        .folder-icon {
            background-color: #ff3d57;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .folder-title {
            font-size: 1.2em;
            color: #333;
        }
    </style>
</head>
<body>

<div class="grid-container">
    <div class="folder-item">
        <div class="folder-icon">≡</div>
        <div class="folder-title">Arsitektur</div>
    </div>
    <div class="folder-item">
        <div class="folder-icon">≡</div>
        <div class="folder-title">Dokumenter</div>
    </div>
    <div class="folder-item">
        <div class="folder-icon">≡</div>
        <div class="folder-title">Seni Rupa</div>
    </div>
    <div class="folder-item">
        <div class="folder-icon">≡</div>
        <div class="folder-title">Fashion</div>
    </div>
    <div class="folder-item">
        <div class="folder-icon">≡</div>
        <div class="folder-title">Olahraga</div>
    </div>
    <div class="folder-item">
        <div class="folder-icon">≡</div>
        <div class="folder-title">Makanan</div>
    </div>
    <div class="folder-item">
        <div class="folder-icon">≡</div>
        <div class="folder-title">Satwa Liar</div>
    </div>
    <div class="folder-item">
        <div class="folder-icon">≡</div>
        <div class="folder-title">Hewan Peliharaan</div>
    </div>
    <div class="folder-item">
        <div class="folder-icon">≡</div>
        <div class="folder-title">Bawah Air</div>
    </div>
    <div class="folder-item">
        <div class="folder-icon">≡</div>
        <div class="folder-title">Perjalanan</div>
    </div>
</div>

</body>
</html>

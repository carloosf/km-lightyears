<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor de Medidas Espaciais</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .my-infos {
            font-size: 15px;
            color: gray;
            text-align: center;
        }

        .title{
            color: #255983;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
        }

        .hidden {
            display: none;
        }

        .sidebar {
            width: 300px;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px 10px;
            border-right: 3px solid #e4e7eb;
        }

        .sidebar a {
            text-decoration: none;
            color: #255983;
            margin: 10px 0;
            font-size: 16px;
            padding: 15px 40px;
            display: block;
            border-radius: 20px;
        }

        .sidebar a:hover {
            background-color: #4b93cc;
            color: white;
        }

        .sidebar a.active {
            background-color: #255983;
            color: white;
        }

        .content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
            height: 60vh;
        }

        .links-container {
            margin-top: 10vh;
        }

        .section {
            padding: 100px;
            border-radius: 15px;
            border: 1px solid #255983;
            width: 400px;
        }

        h1,
        h2 {
            text-align: center;
        }

        .title-section {
            color: #255983;
        }

        input {
            width: 100%;
            padding: 10px;
            background: #f2f2f2;
            border: 1px solid #ccc;
            margin-bottom: 10px;
            border-radius: 10px;
        }

        .button-container {
            display: flex;
            justify-content: center;
        }

        button {
            margin-top: 20px;
            width: 50%;
            padding: 10px;
            background-color: #255983;
            color: #fff;
            border: none;
            border-radius: 20px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .result-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .result {
            background: #f2f2f2;
            color: #255983;
            padding-block: 40px;
            border-radius: 10px;
            display: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 40%;
            max-width: 600px;
            position: relative;
            animation: slideIn 0.3s ease;
            text-align: center;
        }

        @keyframes slideIn {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .result .close {
            position: absolute;
            top: -20px;
            right: 15px;
            background: transparent;
            border: none;
            color: #255983;
            font-size: 20px;
            cursor: pointer;
        }

        .result .close:hover {
            color: #ff6666;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <img src="{{ asset('images/logo_netcon.png') }}" alt="Logo" class="logo">
        <div class="links-container">
            <a href="#km-to-lightyears" class="active" data-target="km-to-lightyears">Km → Anos-Luz</a>
            <a href="#lightyears-to-km" data-target="lightyears-to-km">Anos-Luz → Km</a>
        </div>
    </div>

    <div class="content">
        <h1 class="title">Projeto PHP Necton - Conversor de Anos-Luz/KM</h1>
        <p class="my-infos">Carlos Silva - 21 Anos</p>
        <div class="container">
            <div class="section" id="km-to-lightyears">
                <h2 class="title-section">KM:</h2>
                <input id="kilometers" placeholder="Escreva o valor aqui" oninput="validatePositiveNumber(this)">
                <div class="button-container">
                    <button id="convertKmButton" onclick="convertToLightYears()">Converter →</button>
                </div>
            </div>

            <div class="section" id="lightyears-to-km">
                <h2 class="title-section">Anos-Luz:</h2>
                <input id="lightYears" placeholder="Escreva o valor aqui" oninput="validatePositiveNumber(this)">
                <div class="button-container">
                    <button id="convertLyButton" onclick="convertToKilometers()">Converter →</button>
                </div>
            </div>
        </div>
        <div class="result-container">
            <div class="result" id="result">
                <button class="close" onclick="closeResult()">×</button>
                <span id="resultContent"></span>
            </div>
        </div>
    </div>

    <script>
        function validatePositiveNumber(input) {
            const value = input.value;
            if (!/^\d*\.?\d*$/.test(value)) {
                input.value = value.slice(0, -1);
            }
        }

        function isValidInput(value) {
            return /^\d*\.?\d+$/.test(value);
        }

        async function convertToLightYears() {
            const kilometers = document.getElementById('kilometers').value.trim();
            const button = document.getElementById('convertKmButton');
            const resultDiv = document.getElementById('result');
            const resultContent = document.getElementById('resultContent');

            if (!isValidInput(kilometers)) {
                resultContent.textContent = 'Parâmetros inválidos';
                resultDiv.style.display = 'block';
                return;
            }

            button.disabled = true;
            button.textContent = 'Carregando...';

            try {
                const response = await fetch('/api/quilometros', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        quilometros: parseFloat(kilometers)
                    }),
                });

                if (!response.ok) throw new Error('Erro ao comunicar com a API.');

                const data = await response.json();
                resultContent.textContent = `Resultado: ${data.anosLuz.toFixed(10)} anos-luz`;
            } catch (error) {
                resultContent.textContent = `Erro: ${error.message}`;
            } finally {
                resultDiv.style.display = 'block';
                button.disabled = false;
                button.textContent = 'Converter →';
            }
        }

        async function convertToKilometers() {
            const lightYears = document.getElementById('lightYears').value.trim();
            const button = document.getElementById('convertLyButton');
            const resultDiv = document.getElementById('result');
            const resultContent = document.getElementById('resultContent');

            if (!isValidInput(lightYears)) {
                resultContent.textContent = `Erro: ${error.message}`;
                resultDiv.style.display = 'block';
                return;
            }

            button.disabled = true;
            button.textContent = 'Carregando...';

            try {
                const response = await fetch('/api/anosLuz', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        anosLuz: parseFloat(lightYears)
                    }),
                });

                if (!response.ok) throw new Error('Erro ao comunicar com a API.');

                const data = await response.json();
                resultContent.textContent = `Resultado: ${data.quilometros.toFixed(2)} km`;
            } catch (error) {
                resultContent.textContent = `Erro: ${error.message}`;
            } finally {
                resultDiv.style.display = 'block';
                button.disabled = false;
                button.textContent = 'Converter →';
            }
        }

        function closeResult() {
            document.getElementById('result').style.display = 'none';
        }

        document.addEventListener('DOMContentLoaded', () => {
            const menuLinks = document.querySelectorAll('.sidebar a');
            const sections = document.querySelectorAll('.section');

            sections.forEach(section => section.classList.add('hidden'));
            document.querySelector('#km-to-lightyears').classList.remove('hidden');

            menuLinks.forEach(link => {
                link.addEventListener('click', (event) => {
                    event.preventDefault();

                    menuLinks.forEach(link => link.classList.remove('active'));
                    link.classList.add('active');

                    sections.forEach(section => section.classList.add('hidden'));
                    const targetId = link.getAttribute('data-target');
                    document.getElementById(targetId).classList.remove('hidden');
                });
            });
        });
    </script>
</body>

</html>

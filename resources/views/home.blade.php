<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor de Medidas Espaciais</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
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
            width: 400px;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px 10px;
            border-right: 3px solid #e4e7eb;
        }

        .sidebar h2 {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .sidebar a {
            text-decoration: none;
            color: #255983;
            margin: 10px 0;
            font-size: 16px;
            padding: 10px;
            display: block;
            border-radius: 4px;
        }

        .sidebar a:hover {
            text-decoration: underline;
        }

        .sidebar a.active {
            background-color: #007bff;
            color: white;
        }

        .content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }

        .container {
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
            height: 80vh;
        }
        .section {
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            height: 40vh;
            width: 500px;
        }

        .title {
            font-weight: bold;
            color: #255983;
        }

        h1,
        h2 {
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <img src="{{ asset('images/logo_netcon.png') }}" alt="Logo" class="logo">
        <a href="#km-to-lightyears" class="active" data-target="km-to-lightyears">Km → Anos-Luz</a>
        <a href="#lightyears-to-km" data-target="lightyears-to-km">Anos-Luz → Km</a>
    </div>


    <div class="content">
        <h1 class="title">Projeto PHP Necton - Conversor de Anos-Luz/KM</h1>
        <p class="my-infos">Carlos Silva - 21 Anos</p>

        <div class="container">
            <div class="section" id="km-to-lightyears">
                <h2>Km → Anos-Luz</h2>
                <label for="kilometers">Digite o valor em quilômetros:</label>
                <input type="number" id="kilometers" min="0" placeholder="Insira um valor positivo">
                <button onclick="convertToLightYears()">Converter →</button>
            </div>

            <div class="section" id="lightyears-to-km">
                <h2>Anos-Luz → Km</h2>
                <label for="lightYears">Digite o valor em anos-luz:</label>
                <input type="number" id="lightYears" min="0" placeholder="Insira um valor positivo">
                <button onclick="convertToKilometers()">Converter →</button>
            </div>
        </div>
    </div>

    <script>
        async function convertToLightYears() {
            const kilometers = document.getElementById('kilometers').value;

            if (kilometers === '' || kilometers < 0) {
                alert('Por favor, insira um valor válido (número positivo).');
                return;
            }

            try {
                const response = await fetch('/api/quilometros', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        quilometros: kilometers
                    }),
                });

                if (!response.ok) throw new Error('Erro na API.');

                const data = await response.json();
                alert(`Resultado: ${data.anosLuz.toFixed(10)} anos-luz`);
            } catch (error) {
                alert('Erro: ' + error.message);
            }
        }

        async function convertToKilometers() {
            const lightYears = document.getElementById('lightYears').value;

            if (lightYears === '' || lightYears < 0) {
                alert('Por favor, insira um valor válido');
                return;
            }

            try {
                const response = await fetch('/api/anosLuz', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        anosLuz: lightYears
                    }),
                });

                if (!response.ok) throw new Error('Erro na API.');

                const data = await response.json();
                alert(`Resultado: ${data.quilometros.toFixed(2)} km`);
            } catch (error) {
                alert('Erro: ' + error.message);
            }
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

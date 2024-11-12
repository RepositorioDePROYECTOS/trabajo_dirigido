<?php
// Aquí puedes agregar cualquier lógica de PHP si lo necesitas. Este es un ejemplo estático.
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calentamiento Global Futurista</title>
    <style>
        /* Reset de márgenes y padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: #111;
            color: #fff;
            overflow: hidden;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            transition: background 0.3s ease;
        }

        h1 {
            font-size: 3rem;
            color: #0ff;
            text-shadow: 0 0 10px rgba(0, 255, 255, 0.8);
            margin-bottom: 20px;
        }

        .container {
            text-align: center;
            position: relative;
        }

        .content {
            font-size: 1.2rem;
            line-height: 1.6;
            margin-bottom: 30px;
            max-width: 800px;
            margin: auto;
            text-align: left;
            transition: transform 0.5s ease, opacity 0.5s ease;
            opacity: 1;
        }

        /* Efectos del rastro RGB */
        .cursor-trail {
            position: absolute;
            pointer-events: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            background: rgba(255, 0, 0, 0.8);
            animation: trail-animation 0.6s forwards;
        }

        /* Efecto de animación para el rastro RGB */
        @keyframes trail-animation {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            100% {
                transform: scale(2);
                opacity: 0;
            }
        }

        /* Rastro RGB que cambia de colores */
        .trail-red {
            background: rgba(255, 0, 0, 0.8);
        }
        .trail-green {
            background: rgba(0, 255, 0, 0.8);
        }
        .trail-blue {
            background: rgba(0, 0, 255, 0.8);
        }

        .read-more-btn {
            margin-top: 20px;
            padding: 12px 30px;
            background: linear-gradient(135deg, #00f, #f0f);
            border: none;
            color: #fff;
            font-size: 1.1rem;
            border-radius: 50px;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
            transition: all 0.3s ease;
        }

        .read-more-btn:hover {
            background: linear-gradient(135deg, #ff005a, #4c00ff);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>El Calentamiento Global</h1>

        <div class="content">
            <p>El calentamiento global es un fenómeno que está afectando a nuestro planeta debido a la acumulación de gases de efecto invernadero en la atmósfera. Estos gases, principalmente dióxido de carbono (CO2), metano (CH4) y óxidos de nitrógeno, han causado un aumento en las temperaturas globales, lo que lleva a eventos climáticos extremos, deshielos de los polos y alteraciones en los ecosistemas.</p>
            <p>Los efectos del calentamiento global son cada vez más visibles. Las temperaturas extremas, la pérdida de biodiversidad, y el aumento del nivel del mar son solo algunas de las consecuencias que estamos experimentando.</p>
            <button class="read-more-btn" onclick="readMore()">Leer más</button>
        </div>
    </div>

    <script>
        // Función para cambiar el contenido al hacer clic en "Leer más"
        function readMore() {
            const content = document.querySelector('.content');
            content.style.transform = "translateY(-20px)";
            content.style.opacity = "0.5";
            setTimeout(() => {
                content.innerHTML = `<p>Los científicos advierten que si no tomamos medidas urgentes, los impactos del calentamiento global seguirán empeorando. La transición hacia fuentes de energía renovables, la reforestación, y la reducción de la huella de carbono son pasos cruciales para mitigar el cambio climático y preservar la vida en la Tierra.</p>`;
                content.style.transform = "translateY(0)";
                content.style.opacity = "1";
            }, 500);
        }

        // Crear el rastro RGB al mover el cursor
        let cursorTrail = [];
        let colors = ['trail-red', 'trail-green', 'trail-blue'];

        document.body.addEventListener('mousemove', (e) => {
            let trail = document.createElement('div');
            trail.classList.add('cursor-trail', colors[cursorTrail.length % 3]);
            trail.style.left = `${e.pageX - 10}px`;  // Centrado en el cursor
            trail.style.top = `${e.pageY - 10}px`;
            document.body.appendChild(trail);
            cursorTrail.push(trail);

            // Eliminar el rastro después de la animación
            setTimeout(() => {
                document.body.removeChild(trail);
                cursorTrail.shift();
            }, 600);
        });
    </script>

</body>
</html>

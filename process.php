<?php
// PROCESS.PHP - ОБРАБОТЧИК ФОРМЫ

// Получаем данные из формы
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
$category = isset($_POST['category']) ? trim($_POST['category']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';
$newsletter = isset($_POST['newsletter']) ? $_POST['newsletter'] : 'no';
$response = isset($_POST['response']) ? $_POST['response'] : 'no';

$error = '';
$success = '';

// ПРОВЕРКА 1: ВСЕ ЛИ ПОЛЯ ЗАПОЛНЕНЫ?
if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    $error = "❌ Vyplňte všetky povinné polia!";
} 
// ПРОВЕРКА 2: ПРАВИЛЬНЫЙ ЛИ EMAIL?
elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "❌ Email nie je platný! Zadajte správny email.";
} 
// ПРОВЕРКА 3: СОГЛАСЕН ЛИ НА КОНТАКТ?
elseif ($response !== 'yes') {
    $error = "❌ Musíte súhlasiť s kontaktom cez email!";
} 
// ВСЕ ОК - ОТПРАВЛЯЕМ EMAIL
else {
    $to = 'soffia.bublyk@student.tuke.sk';
    $subject_full = "Cyberpunk World - Nova Sprava: " . $subject;
    
    // ФОРМИРУЕМ ПИСЬМО
    $body = "═══════════════════════════════════════════════\n";
    $body .= "NOVA SPRAVA Z CYBERPUNK WORLD\n";
    $body .= "═══════════════════════════════════════════════\n\n";
    $body .= "OSOBNE INFORMACIE:\n";
    $body .= "─────────────────────────────────────────────\n";
    $body .= "Meno: " . $name . "\n";
    $body .= "Email: " . $email . "\n";
    if (!empty($phone)) {
        $body .= "Telefon: " . $phone . "\n";
    }
    $body .= "\n";
    $body .= "SPRAVA:\n";
    $body .= "─────────────────────────────────────────────\n";
    $body .= "Tema: " . $subject . "\n";
    $body .= "Kategoria: " . $category . "\n";
    $body .= "\n";
    $body .= "Text spravy:\n";
    $body .= $message . "\n";
    $body .= "\n";
    $body .= "UDAJE:\n";
    $body .= "─────────────────────────────────────────────\n";
    $body .= "Cas: " . date('Y-m-d H:i:s') . "\n";
    $body .= "IP Adresa: " . $_SERVER['REMOTE_ADDR'] . "\n";
    $body .= "Newsletter: " . ($newsletter === 'yes' ? 'Ano' : 'Nie') . "\n";
    $body .= "\n";
    $body .= "═══════════════════════════════════════════════\n";
    
    // HLAVICKY EMAILU
    $headers = "From: " . $email . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $headers .= "X-Mailer: Cyberpunk World Contact Form\r\n";
    
    // POKUS POSLAT EMAIL
    if (mail($to, $subject_full, $body, $headers)) {
        $success = "✓ Sprava bola úspešne odoslaná! Vďaka za kontakt.";
    } else {
        $error = "❌ Chyba pri odoslaní. Skúste neskôr.";
    }
}

?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Contact Form Response - Cyberpunk World">
    <title>Response - Cyberpunk</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .response-container {
            max-width: 800px;
            margin: 60px auto;
            padding: 40px;
            background: linear-gradient(135deg, rgba(0, 255, 65, 0.08) 0%, rgba(255, 255, 0, 0.08) 100%);
            border: 2px solid #00ff41;
            box-shadow: 0 0 40px rgba(0, 255, 65, 0.3);
            border-radius: 0;
            text-align: center;
        }

        .response-container h2 {
            font-size: 2em;
            margin-bottom: 20px;
            text-shadow: 0 0 20px rgba(0, 255, 65, 0.5);
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .success-message {
            color: #00ff41;
            font-size: 1.2em;
            margin-bottom: 30px;
            line-height: 1.8;
            text-shadow: 0 0 15px rgba(0, 255, 65, 0.4);
        }

        .error-message {
            color: #ff6464;
            font-size: 1.2em;
            margin-bottom: 30px;
            line-height: 1.8;
            text-shadow: 0 0 15px rgba(255, 100, 100, 0.4);
        }

        .response-info {
            background: rgba(0, 255, 65, 0.1);
            padding: 25px;
            border: 1px solid rgba(0, 255, 65, 0.3);
            margin-bottom: 30px;
            text-align: left;
        }

        .response-info p {
            color: #00ff41;
            margin-bottom: 10px;
            font-size: 0.95em;
        }

        .response-info strong {
            color: #ffff00;
        }

        .response-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .response-btn {
            padding: 12px 30px;
            background: linear-gradient(135deg, #00ff41 0%, #ffff00 100%);
            color: #0a0e0a;
            border: 2px solid #00ff41;
            text-decoration: none;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.9em;
            letter-spacing: 1px;
            box-shadow: 0 0 20px rgba(0, 255, 65, 0.5);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .response-btn:hover {
            box-shadow: 0 0 40px rgba(0, 255, 65, 0.8), 0 0 20px rgba(255, 255, 0, 0.5);
            transform: translateY(-2px);
        }

        .response-btn-secondary {
            background: transparent;
            color: #00ff41;
        }

        .response-btn-secondary:hover {
            background: rgba(0, 255, 65, 0.1);
            color: #ffff00;
            border-color: #ffff00;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo-section">
                <div class="site-logo">
                    <img src="logo.png" alt="Cyberpunk Logo" class="header-logo">
                </div>
                
                <h1>⚡ CYBERPUNK WORLD ⚡</h1>
                <p class="tagline">Enter the Future. Embrace the Code.</p>
            </div>
            <nav class="main-nav">
                <ul>
                    <li><a href="index.html">Domov</a></li>
                    <li><a href="game_features.html">Game Features</a></li>
                    <li><a href="implants.html">Implants</a></li>
                    <li><a href="weapons.html">Weapons</a></li>
                    <li><a href="contact.html">Contact</a></li>
                </ul>
            </nav>
        </header>

        <main class="main-content">
            <div class="response-container">
                <?php if (!empty($success)): ?>
                    <!-- USPECH -->
                    <h2>✓ SPRAVA ODOSLANA</h2>
                    <div class="success-message">
                        <?php echo $success; ?>
                    </div>
                    
                    <div class="response-info">
                        <p><strong>Meno:</strong> <?php echo htmlspecialchars($name); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                        <?php if (!empty($phone)): ?>
                            <p><strong>Telefon:</strong> <?php echo htmlspecialchars($phone); ?></p>
                        <?php endif; ?>
                        <p><strong>Tema:</strong> <?php echo htmlspecialchars($subject); ?></p>
                        <p><strong>Kategoria:</strong> <?php echo htmlspecialchars($category); ?></p>
                        <p><strong>Cas odoslania:</strong> <?php echo date('d.m.Y H:i:s'); ?></p>
                    </div>

                    <div class="response-actions">
                        <a href="index.html" class="response-btn">DOMOV</a>
                        <a href="contact.html" class="response-btn response-btn-secondary">NOVA SPRAVA</a>
                    </div>

                <?php elseif (!empty($error)): ?>
                    <!-- CHYBA -->
                    <h2>❌ CHYBA</h2>
                    <div class="error-message">
                        <?php echo $error; ?>
                    </div>

                    <div class="response-actions">
                        <a href="contact.html" class="response-btn">SPAT NA FORMULAR</a>
                        <a href="index.html" class="response-btn response-btn-secondary">DOMOV</a>
                    </div>

                <?php else: ?>
                    <!-- NICI USPECH ANI CHYBA -->
                    <h2>⚠️ CHYBA</h2>
                    <div class="error-message">
                        Niečo sa stalo zle. Skúste to znovu.
                    </div>

                    <div class="response-actions">
                        <a href="contact.html" class="response-btn">SPAT</a>
                    </div>

                <?php endif; ?>
            </div>
        </main>

        <footer>
            <p>&copy; 2026 Cyberpunk World</p>
            <p>User: [TVOJE IME]</p>
            <p>Date: 2026-01-18</p>
        </footer>
    </div>
</body>
</html>
